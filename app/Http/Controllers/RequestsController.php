<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use App\Helper\Helper;

class RequestsController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requests = Requests::all();
        $count = $requests->count();
        $filters = [];
        if ($request->has('id')) {
            $requests->where('id', '=', $request->id);
            $filters['id'] = $request->id;
        }
        if ($request->has('contact_id')) {
            $requests->where('contact_id', '=', $request->contact_id);
            $filters['contact_id'] = $request->contact_id;
        }
        if ($request->has('channel_id')) {
            $requests->where('channel_id', '=', $request->channel_id);
            $filters['channel_id'] = $request->channel_id;
        }
        if ($request->has('responder_id')) {
            $requests->where('responder_id', '=', $request->responder_id);
            $filters['responder_id'] = $request->responder_id;
        }
        if ($request->has('status')) {
            $requests->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $requests->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $requests->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $requests->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $requests->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $requests->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($requests,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }}
