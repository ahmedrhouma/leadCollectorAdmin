<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Contacts;
use App\Models\Segments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

/**
 * @group  Contacts management
 *
 * APIs for managing Contacts
 */
class ContactsController extends Controller
{
    /**
     * Display a list of contacts.
     *
     * @queryParam  gender String The gender of contact. Example : male/female
     * @queryParam  country String The ISO country code.
     * @queryParam  status Int Status of contact.
     * @queryParam  from Date Date of contact creation.
     * @queryParam  to Date Date of contact cancellation.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "account_id": 1,
     * "user_type": "client",
     * "gender": "male",
     * "first_name": "Eric",
     * "last_name": "Defoe",
     * "birthday": "1990-08-25",
     * "city": "Lille",
     * "country": "france",
     * "nationality": "",
     * "language": "Français",
     * "job": "",
     * "ip_address": "",
     * "browser_data": "",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
     * "fields": [
     * {
     * "field": "Favorite Club",
     * "value": "PSG"
     * }
     * ]
     * },
     * ],
     * "meta": {
     * "total": 10,
     * "links": "",
     * "filters": []
     * }
     *
     * }
     * @response 404 {
     *  "code": "error",
     *  "message": "No contacts yet."
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = Contacts::with('profiles');
        $count = $contacts->count();
        $filters = [];
        if ($request->has('gender') && in_array($request->has('gender'), ["male", "female"])) {
            $contacts->where('gender', '=', $request->gender == "male" ? 1 : 2);
            $filters['gender'] = $request->gender;
        }
        if ($request->has('country')) {
            $contacts->where('country', '=', $request->country);
            $filters['country'] = $request->country;
        }
        if (session()->has('account_id')) {
            $contacts->where('account_id', session('account_id'));
        }
        if ($request->has('status')) {
            $contacts->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $contacts->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $contacts->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $contacts->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $contacts->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $contacts->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($contacts->get(), $count, $filters);
    }

    /**
     * Add new contact.
     *
     * @bodyParam  user_type String required  The type of contact. Example : client / lead / competitor
     * @bodyParam  gender String male / female.
     * @bodyParam  first_name String The contact first name.
     * @bodyParam  last_name String The contact last name.
     * @bodyParam  birthday String The contact birthday.
     * @bodyParam  city String The contact city.
     * @bodyParam  country String The contact country.
     * @bodyParam  nationality String The contact nationality.
     * @bodyParam  language String The contact language.
     * @bodyParam  ip_address String The contact ip address.
     * @bodyParam  browser_data String The contact browser data.
     *
     * @response {
     * "code": "success",
     * "message": "Contact created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "user_type": "client",
     * "gender": "male",
     * "first_name": "Eric",
     * "last_name": "Defoe",
     * "birthday": "1990-08-25",
     * "city": "Lille",
     * "country": "france",
     * "nationality": "",
     * "language": "Français",
     * "ip_address": "",
     * "browser_data": "",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24"
     * }
     * }
     * @response 400 {
     * "code": "error",
     * "message": "Required fields not filled or formats not recognized !"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'user_type' => ['required', 'in:client,lead,competitor'], 'gender' => ['required', 'in:male,female'], 'first_name' => 'required', 'last_name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $requestData = $request->all();
        $requestData['user_type'] = array_search($request->user_type, [1 => 'client', 2 => 'lead', 3 => 'competitor']);
        $requestData['gender'] = array_search($request->gender, [1 => 'male', 2 => 'female']);
        $requestData['status'] = 1;
        $contact = Contacts::create($requestData);
        $contact->refresh();
        Helper::addLog("Add", 4, $contact->id);
        return Helper::createdResponse("contact", $contact);
    }

    /**
     * View contact details.
     *
     * @param Contacts $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contacts $contact)
    {
        return response()->json([
            'code' => 'success',
            'data' => $contact
        ], 200);
    }

    /**
     * Update contact.
     *
     * @urlParam  channel Int required  The id of channel.
     * @bodyParam  status Int required  The status of channel.
     * @bodyParam  name String required  The name of channel.
     * @bodyParam  date_end Date The end date of channel.
     *
     * @response {
     * "code": "success",
     * "message": "Channel updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "media_id": 1,
     * "identifier": "1568941346779",
     * "name": "Facebook page name",
     * "picture": "",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * }
     * }
     * @response 400 {
     * "code": "error",
     * "message": "Unauthorized operation"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @param Contacts $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Contacts $contact)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'user_type' => ['required', 'in:client,lead,competitor'], 'gender' => ['required', 'in:male,female'], 'first_name' => 'required', 'last_name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $account = Accounts::find($request->account_id);
        if ($account == NULL) {
            return response()->json([
                'code' => "Failed",
                'message' => "Account not found"
            ], 400);
        }
        $requestData = $request->all();
        $requestData['user_type'] = array_search($request->user_type, [1 => 'client', 2 => 'lead', 3 => 'competitor']);
        $requestData['gender'] = array_search($request->gender, [1 => 'male', 2 => 'female']);
        $requestData['status'] = 1;
        $contact->update($requestData);
        $result = $contact->wasChanged();
        if ($result) {
            return response()->json([
                "code" => "Success",
                "message" => "Contact updated successfully",
                "data" => $contact,
            ], 200);
        }
        return response()->json([
            "code" => "Failed",
            "message" => "Failed to update Contact : Nothing to update",
        ], 400);
    }

    /**
     * Remove contact
     *
     * @urlParam  contact required Int The id of contact.
     *
     * @response {
     * "code": "success",
     * "message": "contact deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param Contacts $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacts $contact)
    {
        $id = $contact->id;
        $contact->delete();
        Helper::addLog("Delete", 4, $id);
        return response()->json([
            "code" => "Success",
            "message" => "Contact deleted successfully",
        ], 200);
    }

    /**
     * add contact to segment.
     *
     * @bodyParam  contact Int required  The id of contact.
     * @bodyParam  segment Int required  The id of segment.
     *
     * @response {
     * "code": "success",
     * "message": "contact added to segment successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addToSegment(Request $request)
    {
        $validator = Validator::make($request->all(), ['id_segment' => ['required', 'numeric'], 'id_contact' => ['required', 'numeric']], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::find($request->id_segment);
        $segment->contacts()->attach($request->id_contact);
        if ($segment->contacts()->find($request->id_contact)) {
            return response()->json([
                "code" => "Error",
                "message" => "Unexpected error, the contact has not been added to segment.",
            ], 500);
        }
        return response()->json([
            "code" => "Success",
            "message" => "Contact successfully added to segment",
        ], 200);
    }

    /**
     * delete contact from segment.
     *
     * @bodyParam  contact Int required  The id of contact.
     * @bodyParam  segment Int required  The id of segment.
     *
     * @response {
     * "code": "success",
     * "message": "contact deleted from segment successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteFromSegment(Request $request)
    {
        $validator = Validator::make($request->all(), ['id_segment' => ['required', 'numeric'], 'id_contact' => ['required', 'numeric']], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::find($request->id_segment);
        $result = $segment->contacts()->detach($request->id_contact);
        if ($result == 0) {
            return response()->json([
                "code" => "Error",
                "message" => "Unexpected error, the contact has not been removed from segment.",
            ], 500);
        }
        return response()->json([
            "code" => "Success",
            "message" => "Contact removed from segment successfully",
        ], 200);
    }
}
