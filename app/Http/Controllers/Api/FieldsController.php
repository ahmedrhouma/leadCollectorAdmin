<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Fields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (session('account_id')) {
            $fields = Fields::whereNull('account_id')->orWhere('account_id', '=', session('account_id'))->get();
        }else{
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
        return Helper::dataResponse($fields->toArray(),$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [/*'account_id' => 'required|exists:accounts,id',*/'name' => 'required','format' => 'required'], $messages = [
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
        Helper::addLog("Add",5,$field->id);
        return response()->json([
            'code' => "Success",
            'data' => $field
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Fields $field
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Fields $field
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,Fields $field)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','name' => 'required','format' => 'required'], $messages = [
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
            ]);
        }
        $field->update($request->all());
        $result = $field->wasChanged();
        if ($result){
            return response()->json([
                "code"=>"Success",
                "message" => "Field updated successfully",
                "data" => $field,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Contact : Nothing to update",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Fields $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($field)
    {
        $id = $field->id;
        $field->delete();
        Helper::addLog("Delete",3,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Contact deleted successfully",
        ], 200);
    }
}
