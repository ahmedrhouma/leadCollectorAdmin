<?php


namespace App\Helper;


use App\Models\Logs;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class Helper
{
    /**
     * @param $action
     * @param $element
     * @param $element_id
     */
    static function addLog($action,$element,$element_id){
        dd(\Session::get('accessKey_id'));
        Logs::create(["action"=>$action,"element"=>$element,"access_id"=>\Session::get('accessKey_id'),"element_id"=>$element_id]);
    }

    /**
     * @param array $data
     * @param Int $total
     * @param array $filters
     * @return \Illuminate\Http\Response
     */
static function dataResponse(Array $data,$total,Array $filters){
        return response()->json([
            'code' => 'success',
            'data' => $data,
            "meta" => [
                "total" => $total,
                "links" => "",
                "filters" => $filters
            ]
        ],200);
    }

    /**
     * @param $name
     * @param $element
     * @return \Illuminate\Http\Response
     */
    static function createdResponse($name,$element){
        return response()->json([
            'code' => "Success",
            'message' => "$name created successfully",
            'data' => $element
        ],201);
    }

    /**
     * @param array $details
     * @return \Illuminate\Http\Response
     */
static function errorResponse(Array $details){
        return response()->json([
            'code' => "Error",
            'message' => "Required fields not filled or formats not recognized !",
            'details' => $details
        ],400);
    }

    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
static function createErrorResponse($name){
        return response()->json([
            'code' => "Error",
            'message' => "Unexpected error, the $name has not been created."
        ],500);
    }
    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
static function updatedResponse($name,$element){
        return response()->json([
            'code' => "Error",
            'message' => "$name updated successfully.",
            'data' => $element
        ],200);
    }
    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
static function updatedErrorResponse($name){
        return response()->json([
            'code' => "Error",
            'message' => "Failed to update $name : Nothing to update."
        ],400);
    }
    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
static function deleteResponse($name){
        return response()->json([
            'code' => "Success",
            'message' => "$name deleted successfully"
        ],200);
    }

    /**
     * Create token of account
     * @param $account
     * @return string
     * @throws \Exception
     */
    static function generateToken($account)
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
    static function getAccountScopes(){
        return json_encode([
            "contacts.addToSegment",
            "contacts.deleteFromSegment",
            "accessKeys.store",
            "accessKeys.show",
            "accounts.show",
            "accounts.update",
            "authorizations.index",
            "contacts.index",
            "contacts.store",
            "contacts.update",
            "contacts.show",
            "fields.index",
            "fields.store",
            "fields.destroy",
            "fields.update",
            "forms.index",
            "forms.store",
            "forms.destroy",
            "forms.update",
            "forms.show",
            "logs.index",
            "medias.index",
            "messages.index",
            "profiles.index",
            "profiles.store",
            "profiles.destroy",
            "profiles.update",
            "requests.index",
            "responders.index",
            "responders.store",
            "responders.update",
            "responders.show",
            "segments.index",
            "segments.store",
            "segments.update",
            "segments.show",
        ]);
    }
}
