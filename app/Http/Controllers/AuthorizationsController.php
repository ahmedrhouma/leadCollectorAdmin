<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Medias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authorizations = Authorizations::all();
        $count= $authorizations->count();
        $filters = [];
        if ($request->has('media')) {
            $authorizations->where('media', '=', $request->media);
            $filters['media'] = $request->media;
        }
        if ($request->has('account_id')) {
            $authorizations->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $authorizations->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $authorizations->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $authorizations->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $authorizations->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $authorizations->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $authorizations->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($authorizations,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['token' => 'required', 'account_id' => 'required|exists:accounts,id', 'media_id' => 'required|exists:medias,id'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $authorization = Authorizations::create(["token"=> $request->token ,"account_id"=> $request->account_id ,"media_id"=> $request->media_id ,"status"=> 1]);
        Helper::addLog("Add",1,$authorization->id);
        return response()->json([
            'code' => "Success",
            'data' => $authorization
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Authorizations $authorizations
     * @return \Illuminate\Http\Response
     */
    public function show($authorizations)
    {
        return response()->json([
            'code' => 'success',
            'data' => $authorizations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Authorizations $authorizations
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $authorizations)
    {
        $validator = Validator::make($request->all(), ['token' => 'required', 'status' => 'required', 'account_id' => 'required|exists:accounts,id', 'media_id' => 'required|exists:medias,id'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->errors()){
            return Helper::errorResponse($validator->errors()->all());
        }
        $authorizations->update($validator->validated());
        $result = $authorizations->wasChanged();
        if ($result){
            return Helper::updatedResponse('Authorization',$authorizations);
        }
        return Helper::updatedErrorResponse('Authorization');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Authorizations $authorizations
     * @return \Illuminate\Http\Response
     */
    public function destroy($authorizations)
    {
        $authorizations->delete();
        if (is_null($authorizations)){
            return Helper::deleteResponse('Authorization');
        }
        return Helper::deleteErrorResponse('Authorization');
    }
}
