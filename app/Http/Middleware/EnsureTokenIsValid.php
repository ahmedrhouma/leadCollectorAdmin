<?php

namespace App\Http\Middleware;

use App\Models\Access_keys;
use App\Models\Accounts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
class EnsureTokenIsValid
{
    private $adminToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ";
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization') ) {
            return response()->json([
                'code' => 'Error',
                'message' => "Invalid token !"
            ]);
        }
        if ($request->header('Authorization') == $this->adminToken){
            return $next($request);
        }
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $token = $config->parser()->parse($request->header('Authorization'));
        $action = $request->route()->getName();
        /**
         * check if account exist
         */
        $account = Accounts::where('id',$token->claims()->get('uid'))->first();
        if (!$account){
            return response()->json([
                'code' => 'Error',
                'message' => "Invalid account !"
            ]);
        }
        /**
         * check if the account is the owner of the object
         */
        if($request->method() != "POST" && $request->route($request->route()->parameterNames()[0]) && $request->route($request->route()->parameterNames()[0])->account_id != $account->id)
        {
            return response()->json([
                'code' => 'Error',
                'message' => "You are not authorized to execute this command !"
            ]);
        }
        /**
         * check account authorization for current action
         */
        $scope = $account->keys()->whereJsonContains('scopes',$action)->where('token',$request->header('Authorization'))->first();
        if (!$scope){
            return response()->json([
                'code' => 'Error',
                'message' => "You are not authorized to execute this command !"
            ]);
        }
        \Session::put('account_id', $account->id);
        \Session::put('accessKey_id', $scope->id);
        return $next($request);
    }
}
