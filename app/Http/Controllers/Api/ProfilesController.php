<?php

namespace App\Http\Controllers\Api;

use App\Models\Accounts;
use App\Models\Contacts;
use App\Models\Profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
/**
 * @group  Profiles management
 *
 * APIs for managing Profiles
 */
class ProfilesController extends Controller
{
    /**
     * Display list of profiles.
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
        return Helper::dataResponse($profiles->toArray(),$count,$filters);
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
        if ($contact){
            Helper::addLog("Add",7,$contact->id);
            return Helper::createdResponse("Contact",$contact);
        }
        return Helper::createErrorResponse("Contact");
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
            Helper::addLog("Delete",7,$profile->id);
            return Helper::updatedResponse('Profile',$profile);
        }
        return Helper::updatedErrorResponse('Profile');
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
        Helper::addLog("Delete",7,$id);
        if (is_null($profile)){
            return Helper::deleteResponse('Profile');
        }
        return Helper::deleteErrorResponse('Profile');
    }
}
