<?php

namespace App\Http\Controllers;

use App\Models\Medias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;

class MediasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $medias = Medias::all();
        $count = $medias->count();
        $filters = [];
        if ($request->has('status')) {
            $medias->where('status', '=', $request->status);
            $filters['status'] = $request->status;
        }
        if ($request->has('from')) {
            $medias->where('created_at', '>', $request->from);
            $filters['from'] = $request->from;
        }
        if ($request->has('to')) {
            $medias->where('end_at', '<', $request->to);
            $filters['to'] = $request->to;
        }
        if ($request->has('orderBy') && $request->orderBy == 'asc') {
            $medias->sortBy('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('orderBy') && $request->orderBy == 'desc') {
            $medias->sortByDesc('created_at');
            $filters['orderBy'] = $request->orderBy;
        }
        if ($request->has('limit')) {
            $medias->take($request->limit);
            $filters['limit'] = $request->limit;
        }
        return Helper::dataResponse($medias,$count,$filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'tag' => 'required', 'url' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return Helper::errorResponse($validator->errors()->all());
        }
        $media = Medias::create($request->all());
        if ($media){
            return Helper::createdResponse("Media",$media);
        }
        return Helper::createErrorResponse("Media");
    }

    /**
     * Display the specified resource.
     * @param Medias $media
     * @return \Illuminate\Http\Response
     */
    public function show(Medias $media)
    {
        return response()->json([
            'code' => "Failed",
            'data' => $media
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param Medias $media
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Medias $media)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'tag' => 'required', 'url' => 'required'], $messages = [
            'required' => 'The :attribute field is required.',
        ]);
        $media->update($validator->validated());
        $result = $media->wasChanged();
        if ($result){
            return Helper::updatedResponse('Media',$media);
        }
        return Helper::updatedErrorResponse('Media');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Medias $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medias $media)
    {
        $media->delete();
        if (is_null($media)){
            return Helper::deleteResponse('Media');
        }
        return Helper::deleteErrorResponse('Media');
    }
}
