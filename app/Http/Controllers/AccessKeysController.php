<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class AccessKeysController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accessKeys = Access_keys::all();
        $count= $accessKeys->count();
        $filters = [];
        if ($request->has('id')) {
            $accessKeys = Access_keys::find($request->id);
            $filters['id'] = $request->id;
        }
        if ($request->has('status')) {
            $accessKeys->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $accessKeys->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $accessKeys->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $accessKeys->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $accessKeys->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $accessKeys->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($accessKeys,$count,$filters);
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
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $account = Accounts::find($request->account_id);
        $accessKey = Access_keys::create(["token"=>Helper::generateToken($account),"status"=>1,"account_id"=>$account->id,"scopes"=>$request->scopes,"role"=>$request->role ]);
        if ($accessKey){
            return Helper::createdResponse("Access Key",$accessKey) ;
        }
        return Helper::createErrorResponse("Access Key");
    }
    /**
     * Display the specified resource.
     *
     * @param  Access_keys $accessKey
     * @return \Illuminate\Http\Response
     */
    public function show(Access_keys $accessKey)
    {
        return response()->json([
            'code' => 'success',
            'data' => $accessKey
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Access_keys $accessKey
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$accessKey)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'tag' => 'required', 'url' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $accessKey->update($validator->validated());
        $result = $accessKey->wasChanged();
        if ($result){
            Helper::addLog("Update",7,$accessKey->id);
            return Helper::updatedResponse('Access Key',$accessKey);
        }
        return Helper::updatedErrorResponse('Access Key');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Access_keys $accessKey
     * @return \Illuminate\Http\Response
     */
    public function destroy($accessKey)
    {
        $accessKey->delete();
        return Helper::deleteResponse('Access Key');
    }
    /**
     * Display a listing of the scopes.
     *
     * @return \Illuminate\Http\Response
     */
    public function scopes()
    {
        return response()->json([
            "code"=>"Success",
            "data" => Helper::scopes(),
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
