<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Models\Contacts;
use App\Models\Fields;
use App\Models\FieldsValues;
use App\Models\Forms;
use App\Models\Profiles;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;

/**
 * @group  Forms management
 *
 * APIs for managing Forms
 */
class FormsController extends Controller
{
    /**
     * Display a list of forms.
     *
     *
     * @queryParam  status Int Status of field.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "content": "",
     * "url": "https://collector.pro/forms/form1/",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * },
     * {
     * "id": 2,
     * "account_id": 1,
     * "name": "Landing page collector",
     * "content": "",
     * "url": "https://collector.pro/forms/form2/",
     * "status": 1,
     * "date_start": "2021-01-21",
     * "date_end": null
     * }
     * ],
     * "meta": {
     * "total": 10,
     * "links": "",
     * "filters": []
     * }
     * }
     * @response 404 {
     *  "code": "error",
     *  "message": "No forms yet."
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
        $forms = Forms::all();
        $count = $forms->count();
        $filters = [];
        if (session()->has('account_id')) {
            $forms->where('account_id', session('account_id'));
        }
        if ($request->has('account_id')) {
            $forms->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $forms->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $forms->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $forms->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $forms->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $forms->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $forms->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($forms->toArray(), $count, $filters);
    }


    /**
     * Add new form.
     *
     * @bodyParam  content JSON required  Array of fields id.
     * @bodyParam  name String required The name of form.
     *
     * @response {
     * "code": "success",
     * "message": "Form created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "content": "",
     * "url": "https://collector.pro/forms/form1/",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['content' => 'required', 'responder_id' => 'exists:responders:id'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $form = Forms::create($request->all());
        Helper::addLog("Add", 4, $form->id);
        return Helper::createdResponse("form", $form);
    }

    /**
     * View form details.
     *
     * @urlParam  form Int required  The id of form .
     *
     * @response {
     * "code": "success",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "content": "['1','2']",
     * "url": "https://collector.pro/forms/form1/",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * }
     * }
     * }
     * @response 404 {
     * "code": "error",
     * "message": "form not found"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \App\Models\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function show(Forms $forms)
    {
        return response()->json([
            'code' => 'success',
            'data' => $forms
        ], 200);
    }


    /**
     * Update form.
     *
     * @urlParam  form Int required  The id of form.
     * @bodyParam  content JSON required  Array of fields id.
     * @bodyParam  name String required The name of form.
     *
     * @response {
     * "code": "success",
     * "message": "Form updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "content": "['1','2','3']",
     * "url": "https://collector.pro/forms/form1/",
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
     * @param \App\Models\Forms $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forms $form)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'content' => 'required', 'status' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $form->update($request->all());
        $result = $form->wasChanged();
        if ($result) {
            return Helper::updatedResponse('Form', $form);
        }
        return Helper::updatedErrorResponse('Form');

    }

    /**
     * Remove form.
     *
     *
     * @urlParam  form required Int The id of form.
     *
     * @response {
     * "code": "success",
     * "message": "form deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \App\Models\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forms $forms)
    {
        $id = $forms->id;
        $forms->delete();
        Helper::addLog("Delete", 4, $id);
        return response()->json([
            "code" => "Success",
            "message" => "Form deleted successfully",
        ], 200);
    }

    public function formAdd(Request $request, $id)
    {
        $hashids = new Hashids("Diamond Secret", 10);
        $ids = $hashids->decode($id);
        $form = Forms::findOrFail($ids[0]);
        $fields = Fields::whereIn('id', json_decode($form['content']))->get();
        $profile = Profiles::find($ids[1]);
        $changed = false;
        if ($request->has('save')) {
            $data = $request->all();
            $data['ip_address'] = $request->ip();
            $data['browser_data'] = $request->header('User-Agent');
            $data = array_filter($data, fn ($value) => !is_null($value) && $value !== '');
            $profile->update($data);
            $profile->contact->update($data);
            $customFields = $fields->whereNotNull('account_id');
            if ($customFields->count() > 0) {
                foreach ($customFields as $customField) {
                    $fieldValue = FieldsValues::updateOrCreate(['contact_id' => $profile->contact_id, "field_id" => $customField->id], ["value" => $data[$customField->tag]]);
                    if ($fieldValue->changed()) $changed = true;
                }
            }
            if ($profile->wasChanged() || $profile->contact->wasChanged()) $changed = true;
        }
        return view('forms.form', ['fields' => $fields, 'title' => $form['name'], 'flag' => $changed, 'countries' => \App\Helper\Helper::getCountries("EN")]);
    }
}
