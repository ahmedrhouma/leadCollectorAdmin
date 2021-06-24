<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
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
        return Helper::dataResponse($questions,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['responder_id' => 'required|exists:responders,id','message' => 'required','response' => 'required|in:true,false','type' => 'required|in:text,number','order' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $data = $request->all();
        $data['response'] = $data['response']==true?1:0;
        $question = Questions::create($data);
        if ($question){
            Helper::addLog("Add",4,$question->id);
            return Helper::createdResponse("Question",$question);
        }
        return Helper::createErrorResponse("Question");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        return response()->json([
            'code' => 'success',
            'data' => $questions
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Questions $question)
    {
        $validator = Validator::make($request->all(), ['responder_id' => 'required|exists:responders,id','message' => 'required','response' => 'required|in:true,false','type' => 'required|in:text,number','order' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $question->update($request->all());
        $result = $question->wasChanged();
        if ($result){
            return Helper::updatedResponse('Question',$question);
        }
        return Helper::updatedErrorResponse('Question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Questions $questions)
    {
        $id = $questions->id;
        $questions->delete();
        Helper::addLog("Delete",4,$id);
        if (is_null($questions)){
            return Helper::deleteResponse('Question');
        }
        return Helper::deleteErrorResponse('Question');
    }
}
