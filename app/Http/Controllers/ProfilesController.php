<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Contacts;
use App\Models\Profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $profiles = Profiles::all();
        $count = $profiles->count();
        $filters = [];
        if ($request->has('id')) {
            $profiles->where('id', '=', $request->id);
            $filters['id'] = $request->id;
        }
        if ($request->has('contact_id')) {
            $profiles->where('contact_id', '=', $request->contact_id);
            $filters['contact_id'] = $request->contact_id;
        }
        if ($request->has('channel_id')) {
            $profiles->where('channel_id', '=', $request->channel_id);
            $filters['channel_id'] = $request->channel_id;
        }
        if ($request->has('status')) {
            $profiles->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('to')) {
            $profiles->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $profiles->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $profiles->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $profiles->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return $this->dataResponse($profiles,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required','user_type' => ['required','in:client,lead,competitor'],'gender' => ['required','in:male,female'],'first_name' => 'required','last_name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "Failed",
                'data' => $validator->errors()
            ],400);
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
        $contact = Contacts::create($requestData);
        $contact->refresh();
        $this->addLog("Add",7,$contact->id);
        return response()->json([
            'code' => "Success",
            'data' => $contact
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Profiles  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Profiles $profile)
    {
        $profile->update($request->all());
        $result = $profile->wasChanged();
        if ($result){
            $this->addLog("Delete",7,$profile->id);
            return response()->json([
                "code"=>"Success",
                "message" => "Profile updated successfully",
                "data" => $profile,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Profile : Nothing to update",
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Profiles  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy($profile)
    {
        $id = $profile->id;
        $profile->delete();
        $this->addLog("Delete",7,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Profile deleted successfully",
        ], 200);
    }
}
