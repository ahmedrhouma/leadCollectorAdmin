<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class InstagramService
{
    public function __construct()
    {
        $this->fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION'),
        ]);
    }
    public function getUrl(){
        return Socialite::driver('facebook')->scopes(['instagram_basic,instagram_content_publish,instagram_manage_comments,instagram_manage_insights,pages_show_list,pages_read_engagement'])->redirect()->getTargetUrl();
    }
    /**
     * @param String $userToken
     * @return array
     */
    public function getAccounts($userToken)
    {
        try {
            $response = $this->fb->get("/me?fields=instagram_business_account", $userToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        return $response->getDecodedBody();
    }
    /**
     * @param String $userToken
     * @return array
     */
    public function getAccount($userToken,$user_id)
    {
        try {
            $response = $this->fb->get("$user_id?fields=id,username", $userToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        return $response->getDecodedBody();
    }
    /**
     * @param String $userToken
     * @return array
     */
    public function getInstaAccount($userToken,$page_id)
    {
        try {
            $response = $this->fb->get("/$page_id?fields=instagram_business_account", $userToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        return $response->getDecodedBody();
    }
    /**
     * @param $receiver_id
     * @param $message
     * @param $accessToken
     * @param array $suggestions
     * @return void
     */
    public function sendMessage($receiver_id, $message, $accessToken, $suggestions = [])
    {
        $reply = [
            "messaging_type" => "RESPONSE",
            "recipient" => [
                "id" => $receiver_id
            ],

            "message" => [
                "text" => $message
            ]
        ];
        if (count($suggestions) !== 0) {
            $reply["message"]["quick_replies"] = $suggestions;
        }
        try {
            $response = $this->fb->post('/me/messages', $reply, $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $user_id
     * @param $accessToken
     * @return \Facebook\FacebookResponse
     */
    public function getUserProfile($user_name)
    {
        try {
            $response = Http::withHeaders(['User-Agent'=>'Mozilla/5.0 (iPhone; CPU iPhone OS 12_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Instagram 105.0.0.11.118 (iPhone11,8; iOS 12_3_1; en_US; en-US; scale=2.00; 828x1792; 165586599)'])->get("https://i.instagram.com/api/v1/users/4779362205425242/info/");
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        dd($response);
        return $response->getDecodedBody();
    }

    /**
     * @param $user_id
     * @param $accessToken
     * @return \Facebook\FacebookResponse
     */
    public function getPicture($user_id, $accessToken)
    {
        try {
            $response = $this->fb->get("/$user_id/picture?type=small&redirect=false", $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        return $response->getDecodedBody();
    }

    function sendQuickReplies($user_id, $accessToken)
    {
        $replies = [
            "recipient" => [
                "id" => "$user_id"
            ],
            "messaging_type" => "RESPONSE",
            "message" => [
                "text" => "what is your gender ?",
                "quick_replies" => [
                    [
                        "content_type" => "text",
                        "title" => "Male",
                        "payload" => "1",
                    ], [
                        "content_type" => "text",
                        "title" => "Female",
                        "payload" => "2",
                    ]
                ]
            ]
        ];
        try {
            $response = $this->fb->post("/me/messages", $replies, $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}
