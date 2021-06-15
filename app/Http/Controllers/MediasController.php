<?php

namespace App\Http\Controllers;

use App\Models\Medias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return $this->dataResponse($medias,$count,$filters);
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
            return response()->json([
                'code' => "Failed",
                'data' => $validator->errors()
            ]);
        }
        $media = Medias::create($request->all());
        return response()->json([
            'code' => "Failed",
            'data' => $media
        ]);
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
        return response()->json([
            "code"=>$result?"Success":"Error",
            "message" => $result?"Media updated successfully":"Failed to update Media",
            "data" => $result?$media:$validator->errors(),
        ], 200);
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
        return response()->json([
            "code"=>"Success",
            "message" => "Media deleted successfully",
        ], 200);
    }
}
