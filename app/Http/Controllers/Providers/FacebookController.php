<?php

namespace App\Http\Controllers\Providers;

use App\Classes\Matcher;
use App\Helper\Helper;
use App\Models\Accounts;
use App\Models\Authorizations;
use App\Models\Channels;
use App\Models\Contacts;
use App\Models\Medias;
use App\Models\Messages;
use App\Models\Profiles;
use App\Models\Requests;
use App\Services\FacebookService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

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
                return response($challenge, 200);
            } else {
                return response('', 403);
            }
        }
        $data = $request->all();
        $channel = Channels::where('identifier', $data['entry'][0]['id'])->with(['authorization', 'responder', 'accounts'])->first();
        if ($channel->accounts->status == 1) {
            $fb = new FacebookService();
            $userToken = $fb->getBusinessToken($channel->authorization->token, $data['entry'][0]['messaging'][0]['sender']['id']);
            $profile = Profiles::where('identifier', $userToken['token_for_business'])->first();
            if ($profile == null) {
                $user = $fb->getUserProfile($data['entry'][0]['messaging'][0]['sender']['id'], $channel->authorization->token);
                $contact = Contacts::create(
                    [
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'picture' => isset($user['profile_pic']) ? $user['profile_pic'] : NULL,
                        'gender' => isset($user['gender']) ? Helper::getGender($user['gender']) : NULL,
                        'user_type' => 1,
                        'status' => 1,
                        'account_id' => $channel['account_id']
                    ]
                );
                $profile = Profiles::create(
                    ['identifier' => $userToken['token_for_business'],
                        'username' => $user['name'],
                        'picture' => isset($user['profile_pic']) ? $user['profile_pic'] : NULL,
                        'email' => isset($user['email']) ? $user['email'] : NULL,
                        'phone' => isset($user['phone']) ? $user['phone'] : NULL,
                        'contact_id' => $contact->id,
                        'channel_id' => $channel->id,
                        'status' => 1]
                );
            }
            $requests = Requests::where(['contact_id' => $profile->contact_id, 'channel_id' => $channel->id])->get();
            if ($requests->count() < $channel->responder->questions->count() || $requests->where('status', 0)->count() != 0) {
                $responder = new \App\Classes\Channel($channel);
                if ($responder->validate($profile, $data['entry'][0]['messaging'][0]['message']['text'], $requests)) {
                    Messages::create(['content' => $data['entry'][0]['messaging'][0]['message']['text'], 'contact_id' => $profile->contact_id, 'channel_id' => $channel->id]);
                }
                $replies = $responder->getNextQuestion($profile);

                foreach ($replies["messages"] as $reply) {
                    $fb->sendMessage($data['entry'][0]['messaging'][0]['sender']['id'], $reply, $channel->authorization->token, $replies['suggestions'], $replies['templated']);
                }
                if ($requests->where('status', 0)->count() == 0) {
                    var_dump("matched");
                    $matcher = new Matcher();
                    $matcher->matchData($profile->contact);
                }
            }
        }
    }

    /**
     * Facebook callback page.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        if (isset($request->error) && $request->error == "access_denied") {
            return auth()->user() ? redirect()->route('channels') : redirect()->back();
        }
        $account = auth()->user() ? auth()->user()->account()->first() : Accounts::find(session('account_id'));
        if ($account->status == 1) {
            $user = Socialite::driver('facebook')->stateless()->user();
            $fb = new FacebookService();
            $data = $fb->getAccounts($user->token);
            $mediaFB = Medias::where('tag', 'facebook')->first();
            $mediaIG = Medias::where('tag', 'instagram')->first();
            $ids = [];
            foreach ($data['data'] as &$page) {
                $authorization = Authorizations::create(['token' => $page['access_token'], 'status' => 1, 'account_id' => $account->id, 'media_id' => $mediaFB->id]);
                $ids [] = $page['id'];
                Channels::updateOrCreate(['identifier' => $page['id'], 'account_id' => $account->id, 'media_id' => $mediaFB->id], ['identifier' => $page['id'], 'name' => $page['name'], 'picture' => $page['picture']['data']['url'], 'status' => 0, 'account_id' => $account->id, 'media_id' => $mediaFB->id, 'authorization_id' => $authorization->id]);
                if (isset($page['instagram_business_account']) && $mediaIG) {
                    $ids [] = $page['instagram_business_account']['id'];
                    Channels::updateOrCreate(['identifier' => $page['instagram_business_account']['id'], 'account_id' => $account->id, 'media_id' => $mediaIG->id], ['identifier' => $page['instagram_business_account']['id'], 'picture' => isset($page['instagram_business_account']['profile_picture_url']) ? $page['instagram_business_account']['profile_picture_url'] : $page['picture']['data']['url'], 'status' => 0, 'name' => $page['name'], 'account_id' => $account->id, 'media_id' => $mediaIG->id, 'authorization_id' => $authorization->id]);
                }
            }
            $account->channels()->whereNotIn('identifier', $ids)->whereIn("media_id", [$mediaFB->id, $mediaIG ? $mediaIG->id : ""])->where('account_id', $account->id)->delete();
            return auth()->user() ? redirect()->route('channels') : redirect()->back();
        }
    }

    /**
     * Facebook guest callback page.
     */
    public function guestCallback(Request $request, $id)
    {
        \Session::put('account_id', $id);
        return Socialite::driver('facebook')->scopes(['public_profile,pages_show_list,pages_messaging,pages_read_engagement,pages_manage_cta,pages_manage_metadata,instagram_basic,pages_show_list,instagram_manage_messages'])->redirect();
    }
}
