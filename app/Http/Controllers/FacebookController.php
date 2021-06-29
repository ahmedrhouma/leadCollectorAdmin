<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use App\Models\Contacts;
use App\Models\Medias;
use App\Models\Messages;
use App\Models\Profiles;
use App\Models\Requests;
use App\Models\Responders;
use App\Services\FacebookService;
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
        $data = $request->all();
        $channel = Channels::where('identifier',$data['entry'][0]['id'])->with(['authorization','responder'])->first();
        $fb = new FacebookService();
        $profile = Profiles::where('identifier' , $data['entry'][0]['messaging'][0]['sender']['id'])->first();
        if ($profile == null){
            $user = $fb->getUserProfile($data['entry'][0]['messaging'][0]['sender']['id'],$channel->authorization->token);
            $contact = Contacts::create(
                ['identifier' =>  $data['entry'][0]['messaging'][0]['sender']['id'],
                'first_name' =>  $user['first_name'],
                'last_name' => $user['last_name'],
                'picture' =>  $user['profile_pic'],
                'gender' =>  Helper::getGender($user['gender']),
                'user_type' => 1,
                'status' => 1,
                'account_id' =>  $channel['account_id']]
            );
            $profile = Profiles::create(
                ['identifier' =>  $data['entry'][0]['messaging'][0]['sender']['id'],
                'username' =>  $user['name'],
                'picture' =>  $user['profile_pic'],
                'email' =>  isset($user['email'])?$user['email']:NULL,
                'phone' =>  isset($user['phone'])?$user['phone']:NULL,
                'contact_id' =>  $contact->id,
                'channel_id' =>  $channel->id,
                'status' =>  1]
            );
        }
        $message = Messages::create(['content' => $data['entry'][0]['messaging'][0]['message']['text'],'contact_id'=> $profile->contact_id,'channel_id'=> $channel->id]);
        $responder = new \App\Classes\Channel($channel) ;
        $question = $responder->getNextQuestion($profile->contact_id);
        $fb->sendMessage($data['entry'][0]['messaging'][0]['sender']['id'],$question,$channel->authorization->token);
    }

    /**
     * Facebook callback page.
     */
    public function callback()
    {
        $account = auth()->user()->account()->first();
        $user = Socialite::driver('facebook')->stateless()->user();
        $fb = new FacebookService();
        $data = $fb->getAccounts($user->token);
        $existedChannels = $account->channels->pluck('identifier')->all();
        foreach ($data['data'] as &$page) {
            $picture = $fb->getPicture($page['id'], $user->token);
            $page['pictureUrl'] = $picture['data']['url'];
            $authorization = Authorizations::create(['token' => $page['access_token'], 'status' => 1, 'account_id' => $account->id, 'media_id' => Medias::where('tag', 'facebook')->first()->id]);
            if (!in_array($page['id'], $existedChannels)) {
                Channels::create(['identifier' => $page['id'], 'name' => $page['name'], 'picture' => $picture['data']['url'], 'status' => 1, 'account_id' => $account->id, 'media_id' => Medias::where('tag', 'facebook')->first()->id, 'authorization_id' => $authorization->id]);
            }
        }
        $account->channels()->whereNotIn('identifier', array_column($data['data'], 'id'))->delete();
        return redirect()->route('channels');
    }
}
