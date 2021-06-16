<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\Logs;
class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logs = Logs::all();
        $count = $logs->count();
        $filters = [];
        if ($request->has('access_id')) {
            $logs->where('access_id', '=', $request->access_id);
            $filters['access_id'] = $request->access_id;
        }
        if ($request->has('action')) {
            $logs->where('action', '=', $request->action);
            $filters['action'] = $request->action;
        }
        if ($request->has('from')) {
            $logs->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $logs->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy')) {
            if ($request->has('sortBy') && in_array($request->sortBy,['ASC','DESC'])) {
                $logs->orderBy($request->has('orderBy'),$request->sortBy);
                $filters['orderBy'] = $request->orderBy;
                $filters['sortBy'] = $request->sortBy;
            }
        }
        if ($request->has('limit')) {
            $logs->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($logs,$count,$filters);
    }
}
