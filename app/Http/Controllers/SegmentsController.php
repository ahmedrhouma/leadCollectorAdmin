<?php

namespace App\Http\Controllers;

use App\Models\Segments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;

class SegmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = Segments::all();
        $count = $segments->count();
        $filters = [];
        if ($request->has('id')) {
            $segments->where('id', '=', $request->id);
            $filters['id'] = $request->id;
        }
        if ($request->has('account_id')) {
            $segments->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        return Helper::dataResponse($segments,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id','name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::create($request->all());
        $segment->refresh();
        if ($segment){
            Helper::addLog("Add",10,$segment->id);
            return Helper::createdResponse("Segment",$segment);
        }
        return Helper::createErrorResponse("Segment");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Segments  $segment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Segments $segment)
    {
        $segment->update($request->all());
        $result = $segment->wasChanged();
        if ($result){
            Helper::addLog("Update",10,$segment->id);
            return Helper::updatedResponse('Segment',$segment);
        }
        return Helper::updatedErrorResponse('Segment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Segments  $segment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Segments $segment)
    {
        $id = $segment->id;
        $segment->delete();
        Helper::addLog("Delete",10,$id);
        if (is_null($segment)){
            return Helper::deleteResponse('Segment');
        }
        return Helper::deleteErrorResponse('Segment');
    }
}
