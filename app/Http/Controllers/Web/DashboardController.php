<?php

namespace App\Http\Controllers\Web;

use App\Classes\Matcher;
use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Channels;
use App\Models\Contacts;
use App\Models\Medias;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function channels()
    {
        $channels = auth()->user()->account()->first()->channels()->with('media')->get();
        $medias = Medias::all();
        foreach ($medias as $media) {
            $class = "App\Services\\" . ucfirst($media['tag']) . "Service";
            if (class_exists($class)) {
                $obj = new $class;
                $media['redirectUrl'] = $obj->getUrl();
            }
        }
        return view('dashboard.channels', ['channels' => $channels, 'medias' => $medias, 'responders' => auth()->user()->account->responders]);
    }

    public function profile()
    {
        return view('dashboard.profile', ['profile' => auth()->user()->account]);
    }

    public function users()
    {
        $keys = auth()->user()->account()->first()->keys->toArray();
        return view('dashboard.users', ['users' => $keys, 'scopes' => Helper::getViewScopes()]);
    }

    public function updateChannel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:channels,id',
            'responder' => 'required|exists:responders,id',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $channel = Channels::find($request->id);
        $channel->update(['responder_id' => $request->responder, 'status' => $request->status]);
        if ($channel->wasChanged()) {
            return response()->json([
                'code' => "success"
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Nothing to update or Internal error !!"
        ]);
    }

    public function deleteChannel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:channels,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "error",
                'messages' => $validator->errors()->all()
            ]);
        }
        $channel = Channels::find($request->id);
        $channel->delete();
        if (is_null($channel)) {
            return response()->json([
                'code' => "success"
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }

    public function addAccessKey(Request $request)
    {
        $scopes = array_column($request->scopes, 'name');
        $status = $request->status;
        $accessKey = Access_keys::create(["token"=>Helper::generateToken(auth()->user()->account),"status"=>$status,"account_id"=>auth()->user()->account->id,"scopes"=>json_encode($scopes) ]);
        if ($accessKey) {
            return response()->json([
                'code' => "success",
                'data' => $accessKey
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }
    public function updateProfilePic(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs('uploads', auth()->user()->account->id.'.png', 'public');
            return response()->json([
                'code' => "success",
                'path' => $path
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }
    public function updateProfile(Request $request)
    {
        $account = auth()->user()->account;
        $account->update($request->all());
        if ($account->wasChanged()){
            return response()->json([
                'code' => "success",
            ]);
        }
        return response()->json([
            'code' => "error",
            'message' => "Internal error !! please try later."
        ]);
    }
}
