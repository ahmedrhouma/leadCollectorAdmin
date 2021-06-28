<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use App\Models\Medias;
use App\Models\Messages;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    private $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImZhY2Vib29rVG9rZW4iLCJpYXQiOjE1MTYyMzkwMjJ9.44R9jrg3VVNWV2_p9uJNoeUXXoLWHf7gfNFA3UeVELs";

    /**
     * Facebook receive webHooks.
     */
    public function receive(Request $request)
    {
        $message =  Messages::create(['content'=>json_encode($request->all())]);
        $mode = $request->hub_mode;
        $token = $request->hub_verify_token;
        $challenge = $request->hub_challenge;
        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $this->token) {
                return response($request->hub_challenge, 200);
            } else {
                return response('', 403);
            }
        }
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
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        //$account = auth()->user()->account()->first();
        $data = $response->getDecodedBody();
        $existedChannels = Accounts::find(4)->channels->pluck('identifier')->all();
        foreach ($data['data'] as &$page) {
            $picture = $fb->get("/" . $page['id'] . "/picture?type=small&redirect=false", $user->token);
            $picture = $picture->getDecodedBody();
            $page['pictureUrl'] = $picture['data']['url'];
            $authorization = Authorizations::create(['token' => $page['access_token'], 'status' => 1, 'account_id' => 4, 'media_id' => Medias::where('tag', 'facebook')->first()->id]);
            if (!in_array($page['id'], $existedChannels)) {
                Channels::create(['identifier' => $page['id'], 'name' => $page['name'], 'picture' => $picture['data']['url'], 'status' => 1, 'account_id' => 4, 'media_id' => Medias::where('tag', '{facebook}')->first()->id, 'authorization_id' => $authorization->id]);
            }
        }
        Accounts::find(4)->channels()->whereNotIn('identifier', array_column($data['data'], 'id'))->delete();
        return redirect()->route('channels');
    }
}
