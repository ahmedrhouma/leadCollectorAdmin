<?php

namespace App\Http\Controllers\Api;

use App\Models\Messages;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Messages::all();
        $count = $messages->count();
        $filters = [];
        if ($request->has('id')) {
            $messages->where('id', '=', $request->id);
            $filters['id'] = $request->id;
        }
        if ($request->has('request_id')) {
            $messages->where('request_id', '=', $request->request_id);
            $filters['request_id'] = $request->request_id;
        }
        if ($request->has('from')) {
            $messages->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $messages->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $messages->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $messages->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $messages->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($messages,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
