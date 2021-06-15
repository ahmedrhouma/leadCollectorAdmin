<?php

namespace App\Http\Controllers;

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
        return response()->json([
            'code' => 'success',
            'data' => $authorizations,
            "meta" => [
                "total" => $authorizations->count(),
                "links" => "",
                "filters" => $filters
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['token' => 'required', 'account_id' => 'required', 'media_id' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "Failed",
                'data' => $validator->errors()
            ]);
        }
        $account = Accounts::find($request->account_id);
        if ($account == NULL){
            return response()->json([
                'code' => "Failed",
                'message' => "Account not find"
            ]);
        }
        $media = Medias::find($request->media_id);
        if ($media == NULL){
            return response()->json([
                'code' => "Failed",
                'message' => "Media not find"
            ]);
        }
        $authorization = Authorizations::create(["token"=> $request->token ,"account_id"=> $request->account_id ,"media_id"=> $request->media_id ,"status"=> 1]);
        $this->addLog("Add",1,$authorization->id);
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
        $validator = Validator::make($request->all(), ['token' => 'required', 'status' => 'required', 'account_id' => 'required', 'media_id' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        $authorizations->update($validator->validated());
        $result = $authorizations->wasChanged();
        return response()->json([
            "code"=>$result?"Success":"Error",
            "message" => $result?"Authorization updated successfully":"Failed to update Authorization",
            "data" => $result?$authorizations:$validator->errors(),
        ], 200);
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
        return response()->json([
            "code"=>"Success",
            "message" => "Authorization deleted successfully",
        ], 200);
    }
}
