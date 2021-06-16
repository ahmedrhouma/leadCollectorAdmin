<?php


namespace App\Helper;


use App\Models\Logs;

class Helper
{
    /**
     * @param $action
     * @param $element
     * @param $element_id
     */
    function addLog($action,$element,$element_id){
        Logs::create(["action"=>$action,"element"=>$element,"access_id"=>\Session::get('accessKey_id'),"element_id"=>$element_id]);
    }

    /**
     * @param array $data
     * @param Int $total
     * @param array $filters
     * @return \Illuminate\Http\Response
     */
    function dataResponse(Array $data,$total,Array $filters){
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
    function createdResponse($name,$element){
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
    function errorResponse(Array $details){
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
    function createErrorResponse($name){
        return response()->json([
            'code' => "Error",
            'message' => "Unexpected error, the $name has not been created."
        ],500);
    }
    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    function updatedResponse($name,$element){
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
    function updatedErrorResponse($name){
        return response()->json([
            'code' => "Error",
            'message' => "Failed to update $name : Nothing to update."
        ],400);
    }
    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    function deleteResponse($name){
        return response()->json([
            'code' => "Success",
            'message' => "$name deleted successfully"
        ],200);
    }
    function getAccountScopes(){
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
