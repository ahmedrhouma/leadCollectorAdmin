<?php

namespace App\Http\Middleware;

use App\Models\Access_keys;
use App\Models\Accounts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
class EnsureTokenIsValid
{
    private $adminToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization') ||  !$this->verifyToken($request->header('Authorization'),$request)) {
            dd('Invalid token');
        }
        return $next($request);
    }
    private function verifyToken($tokentext,$request)
    {
        if ($tokentext == $this->adminToken){
            return true;
        }
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $token = $config->parser()->parse($tokentext);
        $account = Accounts::find(intval($token->claims()->get('uid')));
        if (!$account){
            dd("Invalid token !");
        }
        \Session::put('account_id', $account->id);
        $accessKey  = Access_keys::where('token',$tokentext)->first();
        \Session::put('accessKey_id', $accessKey->id);
        $scopes = json_decode($accessKey->scopes);
        if (!in_array(Route::getRoutes()->match($request)->action['as'],$scopes)){
            dd("You are not authorized to execute this command !");
        }
        return true;
    }
}
