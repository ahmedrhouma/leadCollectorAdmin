<?php

namespace App\Http\Controllers;

use App\Models\Access_keys;
use DateTimeImmutable;
use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

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
        return response()->json([
            'code' => 'success',
            'data' => $accounts,
            "meta" => [
                "total" => $accounts->count(),
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
        $validator = Validator::make($request->all(), ['first_name' => 'required','last_name' => 'required','email' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'Failed',
                'data' => $validator->errors()
            ]);
        }
        $account = Accounts::create($request->all());
        $accessKey = Access_keys::create(["token"=>$this->generateToken($account),"status"=>1,"account_id"=>$account->id,"scopes"=> $this->getAccountScopes()]);
        return response()->json([
            'code' => false,
            'data' => $account
        ]);
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
            'code' => "Failed",
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
            return response()->json([
                "code"=>"Failed",
                "message" =>"Failed to update Account",
                "data" => $validator->errors(),
            ], 200);
        }
        $account->update($validator->validated());
        $result = $account->wasChanged();
        if ($result){
            return response()->json([
                "code"=>"Success",
                "message" => "Account updated successfully",
                "data" => $account,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Account : Nothing to update",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Accounts $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounts $account)
    {
        $account->delete();
        return response()->json([
            "code"=>"Success",
            "message" => "Account deleted successfully",
        ], 200);
    }
    private function generateToken($account)
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $now   = new DateTimeImmutable();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->withClaim('uid', $account->id)
            ->getToken($configuration->signer(), $configuration->signingKey());
         return $token->toString();
    }
}