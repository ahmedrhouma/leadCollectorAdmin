<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Responders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RespondersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $responders = Responders::all();
        $count = $responders->count();
        $filters = [];
        if ($request->has('account_id')) {
            $responders->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $responders->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $responders->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $responders->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $responders->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $responders->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $responders->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return $this->dataResponse($responders,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required','name' => 'required','content' => 'required'], $messages = [
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
        $responder = Responders::create($request->all());
        $responder->refresh();
        $this->addLog("Add",10,$responder->id);
        return response()->json([
            'code' => "Success",
            'data' => $responder
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function show(Responders $responder)
    {
        return response()->json([
            'code' => 'success',
            'data' => $responder
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responders $responder)
    {
        $responder->update($request->all());
        $result = $responder->wasChanged();
        if ($result){
            $this->addLog("Update",10,$responder->id);
            return response()->json([
                "code"=>"Success",
                "message" => "Responder updated successfully",
                "data" => $responder,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Responder : Nothing to update",
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responders $responder)
    {
        $id = $responder->id;
        $responder->delete();
        $this->addLog("Delete",10,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Responder deleted successfully",
        ], 200);
    }
}
