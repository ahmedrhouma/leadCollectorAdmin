<?php

namespace App\Http\Controllers\Api;

use App\Models\Requests;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

/**
 * @group  Requests management
 *
 * APIs for managing Requests
 */
class RequestsController extends Controller
{

    /**
     * Display a list of requests.
     *
     * @queryParam  contact_id int The id of contact.
     * @queryParam  channel_id int The id of channel.
     * @queryParam  responder_id int The id of responder
     * @queryParam  status Int Status of request.
     * @queryParam  from Date Date of request creation.
     * @queryParam  to Date Date of request cancellation.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "contact_id": 1,
     * "channel_id": 1,
     * "responder_id": 1,
     * "type": "form",
     * "content": "",
     * "status": 1,
     * "date_send": "2021-02-10"
     * },
     * {
     * "id": 2,
     * "contact_id": 3,
     * "channel_id": 1,
     * "responder_id": 4,
     * "type": "message",
     * "content": "name",
     * "status": 1,
     * "date_send": "2020-11-18"
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
     *  "message": "No requests yet."
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     *
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
        return Helper::dataResponse($requests->toArray(), $count, $filters);
    }

}
