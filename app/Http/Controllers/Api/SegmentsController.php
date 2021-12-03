<?php

namespace App\Http\Controllers\Api;

use App\Models\Segments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

/**
 * @group  Segments management
 *
 * APIs for managing Segments
 */
class SegmentsController extends Controller
{
    /**
     * Display a list of segments.
     *
     * @queryParam  name String required The name of segment.
     *
     * @response {
     *   "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "account_id": 1,
     * "name": "Customers"
     * },
     * {
     * "id": 1,
     * "account_id": 1,
     * "name": "Super customers"
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
        return Helper::dataResponse($segments->toArray(), $count, $filters);
    }

    /**
     * Add new segment.
     *
     * @bodyParam  name String required  The name of segment.
     *
     * @response {
     * "code": "success",
     * "message": "Segment created successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "Customers"
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
        $validator = Validator::make($request->all(), ['account_id' => 'required|exists:accounts,id', 'name' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $segment = Segments::create($request->all());
        $segment->refresh();
        if ($segment) {
            Helper::addLog("Add", 10, $segment->id);
            return Helper::createdResponse("Segment", $segment);
        }
        return Helper::createErrorResponse("Segment");
    }

    /**
     * Update segment.
     *
     * @urlParam segment required the id of segment
     * @bodyParam  name String required  The name of segment.
     *
     * @response {
     * "code": "success",
     * "message": "Segment updated successfully",
     * "data": {
     * "id": 1,
     * "account_id": 1,
     * "name": "Customers"
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
     * @param Segments $segment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Segments $segment)
    {
        $segment->update($request->all());
        $result = $segment->wasChanged();
        if ($result) {
            Helper::addLog("Update", 10, $segment->id);
            return Helper::updatedResponse('Segment', $segment);
        }
        return Helper::updatedErrorResponse('Segment');
    }

    /**
     * Remove segment.
     *
     * @urlParam  segment required Int The id of segment.
     *
     * @response {
     * "code": "success",
     * "message": "segment deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param Segments $segment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Segments $segment)
    {
        $id = $segment->id;
        $segment->delete();
        Helper::addLog("Delete", 10, $id);
        if (is_null($segment)) {
            return Helper::deleteResponse('Segment');
        }
        return Helper::deleteErrorResponse('Segment');
    }
}
