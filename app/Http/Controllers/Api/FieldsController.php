<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Fields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group  Fields management
 *
 * APIs for managing Fields
 */
class FieldsController extends Controller
{
    /**
     * Display a list of fields.
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
     * "name": "Hobbies",
     * "tag": "hobby",
     * "format": "text",
     * "status": 1
     * },
     * {
     * "id": 2,
     * "account_id": 1,
     * "name": "Birthday",
     * "tag": "birthday",
     * "format": "date",
     * "status": 1
     * }
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
     *  "message": "No fields yet."
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
        if (session('account_id')) {
            $fields = Fields::whereNull('account_id')->orWhere('account_id', '=', session('account_id'))->get();
        } else {
            $fields = Fields::all();
        }
        $count = $fields->count();
        $filters = [];
        if ($request->has('account_id')) {
            $fields->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }

        if ($request->has('status')) {
            $fields->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('limit')) {
            $fields->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($fields->toArray(), $count, $filters);
    }

    /**
     * Add new custom field.
     *
     * @bodyParam  name String required  The type of contact. Example : client / lead / competitor
     * @bodyParam  format String required The type of field.
     *
     * @response {
     * "code": "success",
     * "message": "Field created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "Hobbies",
     * "tag": "hobby",
     * "format": "text",
     * "status": 1
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
        $validator = Validator::make($request->all(), [/*'account_id' => 'required|exists:accounts,id',*/ 'name' => 'required', 'format' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $requestData = $request->all();
        $requestData['status'] = 1;
        $requestData['tag'] = "tag";
        $field = Fields::create($requestData);
        $field->refresh();
        Helper::addLog("Add", 5, $field->id);
        return response()->json([
            'code' => "Success",
            'data' => $field
        ]);
    }

    /**
     * View field details.
     *
     * @urlParam  field Int required  The id of field .
     *
     * @response {
     * "code": "success",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "Hobbies",
     * "tag": "hobby",
     * "format": "text",
     * "status": 1
     * }
     * }
     * @response 404 {
     * "code": "error",
     * "message": "Field not found"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param Fields $field
     * @return \Illuminate\Http\Response
     */
    public function show($field)
    {
        return response()->json([
            'code' => 'success',
            'data' => $field
        ]);
    }

    /**
     * Update field.
     *
     * @urlParam  field Int required  The id of field.
     * @bodyParam  name String required  The type of contact. Example : client / lead / competitor
     * @bodyParam  format String required The type of field.
     *
     * @response {
     * "code": "success",
     * "message": "Field updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "Hobbies",
     * "tag": "hobby",
     * "format": "text",
     * "status": 1
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
     * @param Fields $field
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Fields $field)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'name' => 'required', 'format' => 'required'], $messages = [
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
            ]);
        }
        $field->update($request->all());
        $result = $field->wasChanged();
        if ($result) {
            return response()->json([
                "code" => "Success",
                "message" => "Field updated successfully",
                "data" => $field,
            ], 200);
        }
        return response()->json([
            "code" => "Failed",
            "message" => "Failed to update Contact : Nothing to update",
        ], 200);
    }

    /**
     * Remove field
     *
     * @urlParam  field required Int The id of field.
     *
     * @response {
     * "code": "success",
     * "message": "field deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param Fields $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($field)
    {
        $id = $field->id;
        $field->delete();
        Helper::addLog("Delete", 3, $id);
        return response()->json([
            "code" => "Success",
            "message" => "Contact deleted successfully",
        ], 200);
    }
}
