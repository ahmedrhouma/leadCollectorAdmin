<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\Medias;
use Laravel\Socialite\Facades\Socialite;
use App\Classes\Facebook;
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
        foreach ($medias as $media){
            $class = "App\Classes\\".ucfirst($media['tag']);
            if (class_exists($class)){
                $obj = new $class;
                $media['redirectUrl'] = $obj->getUrl();
            }
        }
        return view('dashboard.channels',['channels'=>$channels,'medias'=>$medias]);
    }
    public function users()
    {
        return view('dashboard.users');
    }
}
