<?php

namespace App\Http\Controllers\Api;

use App\Models\Messages;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

/**
 * @group  Messages management
 *
 * APIs for managing Messages
 */
class MessagesController extends Controller
{
    /**
     * Display a list of messages.
     * @queryParam  id int The id of message
     * @queryParam  request_id int The ID of request.
     * @queryParam  from Date Date of message creation.
     * @queryParam  to Date Date of message cancellation.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "account_id": 1,
     * "user_type": "client",
     * "gender": "male",
     * "first_name": "Eric",
     * "last_name": "Defoe",
     * "birthday": "1990-08-25",
     * "city": "Lille",
     * "country": "france",
     * "nationality": "",
     * "language": "Français",
     * "job": "",
     * "ip_address": "",
     * "browser_data": "",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
     * "fields": [
     * {
     * "field": "Favorite Club",
     * "value": "PSG"
     * }
     * ]
     * },
     * ],
     * "meta": {
     * "total": 10,
     * "links": "",
     * "filters": []
     * }
     *
     * }
     * @response 404 {
     *  "code": "error",
     *  "message": "No messages yet."
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
        $messages = Messages::all();
        $count = $messages->count();
        $filters = [];
        if (session()->has('account_id')) {
            $messages->where('account_id', session('account_id'));
        }
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
        return Helper::dataResponse($messages->toArray(), $count, $filters);
    }
}
