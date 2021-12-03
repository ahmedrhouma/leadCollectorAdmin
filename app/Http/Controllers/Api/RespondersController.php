<?php

namespace App\Http\Controllers\Api;

use App\Models\Accounts;
use App\Models\Responders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

/**
 * @group  Responders management
 *
 * APIs for managing Responders
 */
class RespondersController extends Controller
{
    /**
     * Display a list of responders.
     *
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
     * "account_id": 1,
     * "name": "First collection bot",
     * "content": "",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * },
     * {
     * "id": 2,
     * "account_id": 1,
     * "name": "Landing page collector",
     * "content": "",
     * "status": 1,
     * "date_start": "2021-01-21",
     * "date_end": null
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
     *  "message": "No responders yet."
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
        $responders = Responders::all();
        $count = $responders->count();
        $filters = [];
        if ($request->has('account_id')) {
            $responders->where('account_id', '=', $request->account_id);
            $filters['account_id'] = $request->account_id;
        }
        if ($request->has('status')) {
            $responders->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $responders->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $responders->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $responders->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $responders->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $responders->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($responders->toArray(), $count, $filters);
    }

    /**
     * Add new responder.
     *
     * @bodyParam  name String required  The name of responder.
     * @bodyParam  type Int required The type of responder. Example : 1 (questions)/2 (form)
     *
     * @response {
     * "code": "success",
     * "message": "Responder created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "type": "1",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * }
     * }
     * @response 400 {
     * "code": "error",
     * "message": "Required fields not filled or formats not recognized !"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $responder = Responders::create(array_merge(['account_id' => session('account_id')], $request->all()));
        $responder->refresh();
        if ($responder) {
            Helper::addLog("Add", 10, $responder->id);
            return Helper::createdResponse("Responder", $responder);
        }
        return Helper::createErrorResponse("Responder");
    }

    /**
     * View responder details.
     * @urlParam responders required the id of responder
     *
     * @param Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function show(Responders $responder)
    {
        return response()->json([
            'code' => 'success',
            'data' => $responder
        ]);
    }

    /**
     * Update responder.
     *
     * @urlParam responders required the id of responder
     * @bodyParam  name String required  The name of responder.
     * @bodyParam  type Int required The type of responder. Example : 1 (questions)/2 (form)
     * @bodyParam  status Int required The status of responder. Example : 0/1
     *
     * @response {
     * "code": "success",
     * "message": "Responder updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "First collection bot",
     * "status": 1,
     * "date_start": "2021-02-10",
     * "date_end": null
     * }
     * }
     * @response 400 {
     * "code": "error",
     * "message": "Unauthorized operation"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \Illuminate\Http\Request $request
     * @param Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responders $responder)
    {
        $responder->update($request->all());
        $result = $responder->wasChanged();
        if ($result) {
            Helper::addLog("Update", 10, $responder->id);
            return Helper::updatedResponse('Responder', $responder);
        }
        return Helper::updatedErrorResponse('Responder');
    }

    /**
     * Remove responder.
     *
     * @urlParam  responder required Int The id of responder.
     *
     * @response {
     * "code": "success",
     * "message": "responder deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param Responders $responder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responders $responder)
    {
        $id = $responder->id;
        $responder->delete();
        Helper::addLog("Delete", 10, $id);
        if (is_null($responder)) {
            return Helper::deleteResponse('Responder');
        }
        return Helper::deleteErrorResponse('Responder');
    }
}
