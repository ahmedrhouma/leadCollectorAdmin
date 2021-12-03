<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Models\Logs;
use App\Http\Controllers\Controller;

/**
 * @group  Logs management
 *
 * APIs for managing Logs
 */
class LogsController extends Controller
{
    /**
     * Display a list of the logs.
     *
     * @queryParam  access_id Int ID of access key.
     * @queryParam  action Int The name of the action.
     * @queryParam  from Date Date of contact creation.
     * @queryParam  to Date Date of contact cancellation.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "access_id": "42",
     * "action": "create",
     * "element": "responder",
     * "element_id": 20,
     * "date": "2020-05-18"
     * },
     * {
     * "id": 1,
     * "access_id": "42",
     * "action": "delete",
     * "element": "field",
     * "element_id": 432,
     * "date": "2019-12-10"
     * }
     * ],
     * "meta": {
     * "total": 10,
     * "links": "",
     * "filters": []
     * }
     * }
     * @response 404 {
     *  "code": "error",
     *  "message": "No logs yet."
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logs = Logs::all();
        $count = $logs->count();
        $filters = [];
        if (session()->has('account_id')) {
            $logs->where('account_id', session('account_id'));
        }
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
            if ($request->has('sortBy') && in_array($request->sortBy, ['ASC', 'DESC'])) {
                $logs->orderBy($request->has('orderBy'), $request->sortBy);
                $filters['orderBy'] = $request->orderBy;
                $filters['sortBy'] = $request->sortBy;
            }
        }
        if ($request->has('limit')) {
            $logs->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($logs->toArray(), $count, $filters);
    }
}
