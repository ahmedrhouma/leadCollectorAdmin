<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Segments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return $this->dataResponse($segments,$count,$filters);
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
            return $this->errorResponse($validator->errors()->all());
        }
        $segment = Segments::create($request->all());
        $segment->refresh();
        $this->addLog("Add",10,$segment->id);
        return response()->json([
            'code' => "Success",
            'data' => $segment
        ],200);
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
            $this->addLog("Update",10,$segment->id);
            return response()->json([
                "code"=>"Success",
                "message" => "Segment updated successfully",
                "data" => $segment,
            ], 200);
        }
        return response()->json([
            "code"=>"Failed",
            "message" =>"Failed to update Segment : Nothing to update",
        ], 400);
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
        $this->addLog("Delete",10,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Segment deleted successfully",
        ], 200);
    }
}
