<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Forms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forms = Forms::all();
        $count = $forms->count();
        $filters = [];
        if ($request->has('account_id')) {
            $forms->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $forms->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $forms->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $forms->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $forms->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $forms->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $forms->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($forms,$count,$filters);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','content' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $form = Forms::create($request->all());
        Helper::addLog("Add",4,$form->id);
        return Helper::createdResponse("form",$form);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function show(Forms $forms)
    {
        return response()->json([
            'code' => 'success',
            'data' => $forms
        ],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forms  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forms $form)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','content' => 'required','status' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $form->update($request->all());
        $result = $form->wasChanged();
        if ($result){
            return Helper::updatedResponse('Form',$form);
        }
        return Helper::updatedErrorResponse('Form');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forms $forms)
    {
        $id = $forms->id;
        $forms->delete();
        Helper::addLog("Delete",4,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Form deleted successfully",
        ], 200);
    }
}
