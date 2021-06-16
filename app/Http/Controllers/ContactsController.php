<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Contacts;
use App\Models\Segments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = Contacts::all();
        $count =$contacts->count();
        $filters = [];
        if ($request->has('gender') && in_array($request->has('gender'),["male","female"])) {
            $contacts->where('gender', '=', $request->gender == "male"?1:2);
            $filters['gender'] = $request->gender;
        }
        if ($request->has('country')) {
            $contacts->where('country', '=', $request->country);
            $filters['country'] = $request->country;
        }
        if ($request->has('account_id')) {
            $contacts->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
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
         return Helper::dataResponse($contacts,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','user_type' => ['required','in:client,lead,competitor'],'gender' => ['required','in:male,female'],'first_name' => 'required','last_name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $requestData = $request->all();
        $requestData['user_type'] = array_search($request->user_type,[1=>'client',2=>'lead',3=>'competitor']);
        $requestData['gender'] = array_search($request->gender,[1=>'male',2=>'female']);
        $requestData['status'] = 1;
        $contact = Contacts::create($requestData);
        $contact->refresh();
        Helper::addLog("Add",4,$contact->id);
        return Helper::createdResponse("contact",$contact);
    }

    /**
     * Display the specified resource.
     *
     * @param  Contacts $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contacts $contact)
    {
        return response()->json([
            'code' => 'success',
            'data' => $contact
        ],200);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  Contacts $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,Contacts $contact)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','user_type' => ['required','in:client,lead,competitor'],'gender' => ['required','in:male,female'],'first_name' => 'required','last_name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $account = Accounts::find($request->account_id);
        if ($account == NULL){
            return response()->json([
                'code' => "Failed",
                'message' => "Account not found"
            ],400);
        }
        $requestData = $request->all();
        $requestData['user_type'] = array_search($request->user_type,[1=>'client',2=>'lead',3=>'competitor']);
        $requestData['gender'] = array_search($request->gender,[1=>'male',2=>'female']);
        $requestData['status'] = 1;
        $contact->update($requestData);
        $result = $contact->wasChanged();
        if ($result){
            return response()->json([
                "code"=>"Success",
                "message" => "Contact updated successfully",
                "data" => $contact,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Contact : Nothing to update",
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contacts $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacts $contact)
    {
        $id = $contact->id;
        $contact->delete();
        Helper::addLog("Delete",4,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Contact deleted successfully",
        ], 200);
    }
    /**
     * add contact to segment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToSegment(Request $request)
    {
        $validator = Validator::make($request->all(), ['id_segment' => ['required','numeric'],'id_contact' => ['required','numeric']], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::find($request->id_segment);
        $segment->contacts()->attach($request->id_contact);
        if ($segment->contacts()->find($request->id_contact)){
            return response()->json([
                "code"=>"Error",
                "message" => "Unexpected error, the contact has not been added to segment.",
            ], 500);
        }
        return response()->json([
            "code"=>"Success",
            "message" => "Contact successfully added to segment",
        ], 200);
    }
    /**
     * delete contact segment segment.

     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteFromSegment(Request $request)
    {
        $validator = Validator::make($request->all(), ['id_segment' => ['required','numeric'],'id_contact' => ['required','numeric']], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::find($request->id_segment);
        $result = $segment->contacts()->detach($request->id_contact);
        if ($result == 0){
            return response()->json([
                "code"=>"Error",
                "message" => "Unexpected error, the contact has not been removed from segment.",
            ], 500);
        }
        return response()->json([
            "code"=>"Success",
            "message" => "Contact removed from segment successfully",
        ], 200);
    }
}
