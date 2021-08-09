<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Channels;
use App\Models\Medias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class ChannelsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $channels = Channels::all();
        $count =$channels->count();
        $filters = [];
        if ($request->has('media')) {
            $channels->where('media', '=', $request->media);
            $filters['media'] = $request->media;
        }
        if ($request->has('account_id')) {
            $channels->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $channels->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $channels->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $channels->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $channels->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $channels->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $channels->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($channels,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'media_id|exists:medias,id' => 'required', 'identifier' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $channel = Channels::create($request->all());
        Helper::addLog("Add",3,$channel->id);
        return response()->json([
            'code' => "Success",
            'data' => $channel
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Channels $channel
     * @return \Illuminate\Http\Response
     */
    public function show($channel)
    {
        return response()->json([
            'code' => 'success',
            'data' => $channel
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channels $channel
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $channel)
    {
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'media_id' => 'required', 'identifier' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        $channel->update($validator->validated());
        $result = $channel->wasChanged();
        Helper::addLog("Update",3,$channel->id);
        return response()->json([
            "code"=>$result?"Success":"Error",
            "message" => $result?"Channel updated successfully":"Failed to update Channel",
            "data" => $result?$channel:$validator->errors(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Channels $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel)
    {
        $id = $channel->id;
        $channel->delete();
        Helper::addLog("Delete",3,$id);
        return response()->json([
            "code"=>"Success",
            "message" => "Channel deleted successfully",
        ], 200);
    }
}
