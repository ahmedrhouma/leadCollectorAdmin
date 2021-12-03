<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use App\Http\Controllers\Controller;

/**
 * @group  Access Keys management
 *
 * APIs for managing access Keys
 */
class AccessKeysController extends Controller
{
    /**
     * Display a list of access Keys.
     * @queryParam  id Int The id of access key.
     * @queryParam  account_id Int The id of account.
     * @queryParam  role String The role of access key.
     * @queryParam  status Int Status of access key.
     * @queryParam  from Date Date of account creation.
     * @queryParam  to Date Date of account cancellationy.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "name": "ADMIN",
     * "token": "token",
     * "scopes": "[\"contacts.store\",\"contacts.update\"]",
     * "status": 1,
     * "end_at": null,
     * "account_id": 1,
     * "created_at": "2021-09-10T14:24:20.000000Z",
     * "updated_at": "2021-09-16T14:08:32.000000Z"
     * },
     * {
     * "id": 2,
     * "name": "secrétaire",
     * "token": "token",
     * "scopes": "[\"contacts.addToSegment\"]",
     * "status": 1,
     * "end_at": null,
     * "account_id": 1,
     * "created_at": "2021-09-16T12:39:19.000000Z",
     * "updated_at": "2021-09-16T14:08:40.000000Z"
     * }
     * ],
     * "meta": {
     * "total": 2,
     * "links": "",
     * "filters": []
     * }
     * }
     * @response 404 {
     *  "code": "error",
     *  "message": "No access keys yet."
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     */
    public function index(Request $request)
    {
        $accessKeys = Access_keys::all();
        $count = $accessKeys->count();
        $filters = [];
        if ($request->has('id')) {
            $accessKeys = Access_keys::find($request->id);
            $filters['id'] = $request->id;
        }

        if (session()->has('account_id')) {
            $accessKeys->where('account_id', session('account_id'));
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
        return Helper::dataResponse($accessKeys->toArray(), $count, $filters);
    }

    /**
     * Add new access key.
     *
     * @bodyParam  name required String The name of access key.
     * @bodyParam  scopes required JSON The scopes of access key.
     *
     * @response {
     * "code": "success",
     * "message": "Access key created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "token": "Klskdfhl357MLKJHLKJsdfg2dfg65s4dgsd4g5",
     * "role": "user",
     * "scopes": "",
     * "status": 1,
     * "date_start": "2020-05-18",
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
        $accessKey = Access_keys::create(["token" => Helper::generateToken($account), "status" => 1, "account_id" => $account->id, "scopes" => $request->scopes, "role" => $request->role]);
        if ($accessKey) {
            return Helper::createdResponse("Access Key", $accessKey);
        }
        return Helper::createErrorResponse("Access Key");
    }


    /**
     * Update access key.
     *
     * @urlParam  accessKey required Int The id of access key.
     *
     * @response {
     * "code": "success",
     * "message": "Access key updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "token": "Klskdfhl357MLKJHLKJsdfg2dfg65s4dgsd4g5",
     * "role": "user",
     * "scopes": "",
     * "status": 1,
     * "date_start": "2020-05-18",
     * "date_end": null
     * }
     * }
     * @response 400 {
     * "code": "error",
     * "message": "Unauthorized operation"
     * }
     * @response 500 {
     * "code": "error",
     * "message": "Unexpected error, the access key has not been updated."
     * }
     *
     * @param \Illuminate\Http\Request $request
     * @param Access_keys $accessKey
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Access_keys $accessKey)
    {
        $validator = Validator::make($request->all(), ['scopes' => 'required', 'status' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);

        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $accessKey->update($validator->validated());
        $result = $accessKey->wasChanged();
        if ($result) {
            Helper::addLog("Update", 7, $accessKey->id);
            return Helper::updatedResponse('Access Key', $accessKey);
        }
        return Helper::updatedErrorResponse('Access Key');
    }

    /**
     * Remove access key.
     *
     * @urlParam  accessKey required Int The id of access key.
     *
     * @response {
     * "code": "success",
     * "message": "Access key deleted successfully"
     * }
     * @response 500 {
     * "code": "error",
     * "message": "Unexpected error, the access key has not been deleted"
     * }
     * @param Access_keys $accessKey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Access_keys $accessKey)
    {
        $accessKey->delete();
        return Helper::deleteResponse('Access Key');
    }

    /**
     * Display a list of scopes.
     * @response {
     * "code": "success",
     * "data": ["scope1.action","scope1.action2","scope2.action"]
     * }
     * @return \Illuminate\Http\Response
     */
    public function scopes()
    {
        return response()->json([
            "code" => "Success",
            "data" => Helper::scopes(),
        ], 200);
    }

    private function generateToken($account)
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $now = new DateTimeImmutable();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->withClaim('uid', $account->id)
            ->getToken($configuration->signer(), $configuration->signingKey());
        return $token->toString();
    }
}
