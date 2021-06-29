<?php


namespace App\Services;


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

    /**
     * @param String $userToken
     * @return array
     */
    public function getAccounts($userToken)
    {
        try {
            $response = $this->fb->get('/me/accounts', $userToken);
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
    public function sendMessage($receiver_id,$message,$accessToken)
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
        try {
            $response = $this->fb->post('/me/messages', $reply , $accessToken);
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
    public function getUserProfile($user_id,$accessToken)
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
}
