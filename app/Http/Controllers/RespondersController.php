<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Responders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;

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
        return Helper::dataResponse($responders,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','name' => 'required','content' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $responder = Responders::create($request->all());
        $responder->refresh();
        if ($responder){
            Helper::addLog("Add",10,$responder->id);
            return Helper::createdResponse("Responder",$responder);
        }
        return Helper::createErrorResponse("Responder");
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
            Helper::addLog("Update",10,$responder->id);
            return Helper::updatedResponse('Responder',$responder);
        }
        return Helper::updatedErrorResponse('Responder');
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
        Helper::addLog("Delete",10,$id);
        if (is_null($responder)){
            return Helper::deleteResponse('Responder');
        }
        return Helper::deleteErrorResponse('Responder');
    }
}
