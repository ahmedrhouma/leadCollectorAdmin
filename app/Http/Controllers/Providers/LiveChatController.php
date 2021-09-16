<?php

namespace App\Http\Controllers\Providers;

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

class LiveChatController extends Controller
{

    /**
     * Live chat receive webHooks.
     */
    public function receive(Request $request)
    {
        $data = $request->all();
        $channel = Channels::where('identifier', $data['key'])->with(['authorization', 'responder'])->first();
        $profile = Profiles::where('identifier', $data['identifier'])->first();
        if (is_null($profile)) {
            $contact = Contacts::create(
                [
                    'user_type' => 1,
                    'account_id' => $channel->account_id,
                    'ip_address' => $request->ip(),
                    'browser_data' => $data['browser_data'],
                    'status' => 1
                ]
            );
            $profile = Profiles::create(
                [
                    'identifier' => uniqid(),
                    'contact_id' => $contact->id,
                    'channel_id' => $channel->id,
                    'status' => 1
                ]);
        }
        $requests = Requests::where(['contact_id' => $profile->contact_id, 'channel_id' => $channel->id])->get();

        if ($requests->count() < $channel->responder->questions->count() || $requests->where('status', 0)->count() != 0) {
            $responder = new \App\Classes\Channel($channel);
            if ($responder->validate($profile, $data['message'], $requests)) {
                Messages::create(['content' => $data['message'], 'contact_id' => $profile->contact_id, 'channel_id' => $channel->id]);
            }
            $replies = $responder->getNextQuestion($profile);
            return response()->json([
                "messages" => $replies["messages"],
                "identifier" => $profile->identifier
            ]);
        }

    }

    /**
     * Facebook callback page.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        $account = auth()->user() ? auth()->user()->account()->first() : Accounts::find(session('account_id'));
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
            if (isset($page['instagram_business_account'])) {
                $ids [] = $page['instagram_business_account']['id'];
                Channels::updateOrCreate(['identifier' => $page['instagram_business_account']['id'], 'account_id' => $account->id, 'media_id' => $mediaIG->id], ['identifier' => $page['instagram_business_account']['id'], 'picture' => isset($page['instagram_business_account']['profile_picture_url']) ? $page['instagram_business_account']['profile_picture_url'] : $page['picture']['data']['url'], 'status' => 0, 'name' => $page['name'], 'account_id' => $account->id, 'media_id' => $mediaIG->id, 'authorization_id' => $authorization->id]);
            }
        }
        $account->channels()->whereNotIn('identifier', $ids)->whereIn("media_id", [$mediaFB->id, $mediaIG->id])->where('account_id', $account->id)->delete();
        return auth()->user() ? redirect()->route('channels') : redirect($account->company_url);
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
