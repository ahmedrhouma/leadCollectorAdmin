<?php

namespace App\Http\Controllers;

use App\Models\Access_keys;
use DateTimeImmutable;
use Illuminate\Http\Request;
use App\Models\Accounts;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use App\Helper\Helper;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accounts = Accounts::all();
        $count = $accounts->count();
        $filters = [];
        if ($request->has('status')) {
            $accounts->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $accounts->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $accounts->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $accounts->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $accounts->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $accounts->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($accounts,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['first_name' => 'required','last_name' => 'required','email' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $account = Accounts::create($request->all());
        $accessKey = Access_keys::create(["token"=>Helper::generateToken($account),"status"=>1,"account_id"=>$account->id,"scopes"=> Helper::getAccountScopes()]);
        if ($accessKey){
            //Helper::addLog("Add",10,$accessKey->id);
            return Helper::createdResponse("Access Key",$accessKey);
        }
        return Helper::createErrorResponse("Access Key");
    }

    /**
     * Display the specified resource.
     *
     * @param  Accounts  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Accounts $account)
    {
        $account->load('keys');
        return response()->json([
            'code' => "Success",
            'data' => $account
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  Accounts $account
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,Accounts $account)
    {
        $validator = Validator::make($request->all(), ['first_name' => 'required','last_name' => 'required','email' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->errors()){
            return Helper::errorResponse($validator->errors()->all());
        }
        $account->update($validator->validated());
        $result = $account->wasChanged();
        if ($result){
            return Helper::updatedResponse('Account',$account);
        }
        return Helper::updatedErrorResponse('Account');
    }

    /**
     * Remove the specified resource from storage.
     * @param  Accounts $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounts $account)
    {
        $account->delete();
        if (is_null($account)){
            return Helper::deleteResponse('Account');
        }
        return Helper::deleteErrorResponse('Account');
    }

}
