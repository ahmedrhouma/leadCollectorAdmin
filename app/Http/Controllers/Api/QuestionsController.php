<?php

namespace App\Http\Controllers\Api;

use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use App\Http\Controllers\Controller;

/**
 * @group  Questions management
 *
 * APIs for managing Questions
 */
class QuestionsController extends Controller
{
    /**
     * Display a list of questions.
     *
     * @queryParam  responder_id int The id of question.
     * @queryParam  field_id int The id of field.
     * @queryParam  status Int Status of question.
     * @queryParam  order Int order of question.
     * @queryParam  from Date Date of question creation.
     * @queryParam  to Date Date of question cancellation.
     * @queryParam  orderBy String Field name.
     * @queryParam  sortBy The supported sort directions are either ‘asc’ for ascending or ‘desc’ for descending.
     * @queryParam  limit Int The number of items returned in the response.
     *
     * @response {
     * "code": "success",
     * "data": [
     * {
     * "id": 1,
     * "responder_id": 1,
     * "field_id": null,
     * "response": "0",
     * "order": "1",
     * "message": "hello and welcome",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
     * },
     * {
     * "id": 2,
     * "responder_id": 1,
     * "field_id": 1,
     * "response": "1",
     * "order": "2",
     * "message": "What is your first name ?",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
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
     *  "message": "No questions yet."
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
        $questions = Questions::all();
        $count = $questions->count();
        $filters = [];
        if ($request->has('responder_id')) {
            $questions->where('responder_id', '=', $request->responder_id);
            $filters['responder_id'] = $request->responder_id;
        }
        if ($request->has('status')) {
            $questions->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $questions->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $questions->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $questions->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $questions->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $questions->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($questions->toArray(), $count, $filters);
    }

    /**
     * Add new question.
     *
     * @bodyParam  responder_id Int required  The id of responder.
     * @bodyParam  field_id Int required The id of field.
     * @bodyParam  message String The question content.
     * @bodyParam  response Boolean The question have response or not.
     * @bodyParam  order int The order of the question.
     *
     * @response {
     * "code": "success",
     * "message": "Question created successfully",
     * "data": {
     * "id": 1,
     * "responder_id": 1,
     * "field_id": null,
     * "response": "0",
     * "order": "1",
     * "message": "hello and welcome",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
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
        $validator = Validator::make($request->all(), ['responder_id' => 'required|exists:responders,id', 'message' => 'required', 'response' => 'required|in:true,false', 'order' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $data = $request->all();
        $data['response'] = $data['response'] == "true" ? 1 : 0;
        $data['status'] = 1;
        $question = Questions::create($data);
        if ($question) {
            Helper::addLog("Add", 4, $question->id);
            return Helper::createdResponse("Question", $question);
        }
        return Helper::createErrorResponse("Question");
    }

    /**
     * View Question details .
     *
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        return response()->json([
            'code' => 'success',
            'data' => $questions
        ], 200);
    }

    /**
     * Update Question.
     *
     * @urlParam  question Int required the question id.
     * @bodyParam  responder_id Int The id of responder.
     * @bodyParam  field_id Int  The id of field.
     * @bodyParam  message String The question content.
     * @bodyParam  response Boolean The question have response or not.
     * @bodyParam  order int The order of the question.
     *
     * @response {
     * "code": "success",
     * "message": "Question updated successfully",
     * "data": {
     * "id": 1,
     * "responder_id": 1,
     * "field_id": null,
     * "response": "0",
     * "order": "1",
     * "message": "hello and welcome",
     * "status": 1,
     * "date_creation": "2021-02-10",
     * "date_updated": "2021-04-24",
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
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Questions $question)
    {
        $validator = Validator::make($request->all(), ['responder_id' => 'required|exists:responders,id', 'message' => 'required', 'response' => 'required|in:true,false', 'type' => 'required|in:text,number', 'order' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $question->update($request->all());
        $result = $question->wasChanged();
        if ($result) {
            return Helper::updatedResponse('Question', $question);
        }
        return Helper::updatedErrorResponse('Question');
    }

    /**
     * Remove question.
     *
     * @urlParam  question required Int The id of question.
     *
     * @response {
     * "code": "success",
     * "message": "question deleted successfully"
     * }
     * @response 500 {
     *  "code": "error",
     *  "message": "Unexpected error, please contact technical support."
     * }
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Questions $questions)
    {
        $id = $questions->id;
        $questions->delete();
        Helper::addLog("Delete", 4, $id);
        if (is_null($questions)) {
            return Helper::deleteResponse('Question');
        }
        return Helper::deleteErrorResponse('Question');
    }
}
