<?php


namespace App\Services;


use Laravel\Socialite\Facades\Socialite;

class FacebookService
{
    public function __construct()
    {
        $this->fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION'),
        ]);
    }

    public function getUrl()
    {
        return Socialite::driver('facebook')->usingGraphVersion('v11.0')->scopes(['public_profile,pages_show_list,pages_messaging,pages_read_engagement,pages_manage_cta,pages_manage_metadata,instagram_basic,instagram_manage_messages'])->redirect()->getTargetUrl();
    }

    /**
     * @param String $userToken
     * @return array
     */
    public function getBusinessToken($userToken, $PSID)
    {
        try {
            $response = $this->fb->get("$PSID?fields=token_for_business", $userToken);
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
    public function getAccounts($userToken)
    {
        try {
            $response = $this->fb->get('me/accounts?fields=name,id,picture,access_token,instagram_business_account{id,username,profile_picture_url}', $userToken);
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
    public function sendMessage($receiver_id, $message, $accessToken, $suggestions = [], $templated = true)
    {
        if ($templated) {
            $reply = [
                "messaging_type" => "RESPONSE",
                "recipient" => [
                    "id" => $receiver_id
                ],

                "message" => [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "generic",
                            "elements" => [
                                [
                                    "title" => "Welcome! Thanks for your message :)",
                                    "image_url" => "https://beta.myplatform.pro/assets/img/brand/blue.png",
                                    "subtitle" => "To more understand your desire please respond this form.",
                                    "default_action" => [
                                        "type" => "web_url",
                                        "url" => "$message",
                                        "webview_height_ratio" => "tall",
                                    ],
                                    "buttons" => [
                                        [
                                            "type" => "web_url",
                                            "url" => "$message",
                                            "title" => "Subscribe"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $reply = [
                "messaging_type" => "RESPONSE",
                "recipient" => [
                    "id" => $receiver_id
                ],

                "message" => [
                    "text" => $message
                ]
            ];
        }

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
    public function getUserProfile($user_id, $accessToken)
    {
        try {
            $response = $this->fb->get("/$user_id?fields=first_name,last_name,profile_pic,gender,name,email", $accessToken);
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
