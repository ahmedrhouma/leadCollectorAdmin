<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
class FacebookController extends Controller
{
    /**
     * Facebook login page.
     */
    public function login()
    {
        $facebookUrl = Socialite::driver('facebook')->scopes(['public_profile,pages_show_list,pages_messaging,pages_read_engagement,pages_manage_cta,pages_manage_metadata'])->redirect()->getTargetUrl();
        $channels = Channels::where(['account_id'=>1,'media_id'=> 1])->get();
        return view('pagesList',['facebookPages'=>$channels,'url'=>$facebookUrl,'total'=>count($channels)]);
    }
    /**
     * Facebook callback page.
     */
    public function callback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION'),
        ]);
        try {
            $response = $fb->get('/me/accounts', $user->token);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $data = $response->getDecodedBody();
        $existedChannels = Accounts::find(1)->channels->pluck('identifier')->all();
        foreach ($data['data'] as &$page){
            $picture = $fb->get("/".$page['id']."/picture?type=small&redirect=false", $user->token);
            $picture = $picture->getDecodedBody();
            $page['pictureUrl'] = $picture['data']['url'];
            $authorization = Authorizations::create(['token'=>$page['access_token'],'status'=>1,'account_id'=>1,'media_id'=>1]);
            if (!in_array($page['id'],$existedChannels)){
                Channels::create(['identifier'=>$page['id'],'name'=>$page['name'],'picture'=>$picture['data']['url'],'status'=>1,'account_id'=>1,'media_id'=>1,'authorization_id'=>$authorization->id]);
            }
        }
        Accounts::find(1)->channels()->whereNotIn('identifier',array_column($data['data'],'id'))->delete();
        return redirect()->route('facebookLogin');
    }
}
