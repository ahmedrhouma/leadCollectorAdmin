<?php


namespace App\Classes;

use Laravel\Socialite\Facades\Socialite;

class Instagram
{
    public function getUrl(){
        return Socialite::driver('instagrambasic')->scopes(['user_profile,user_media'])->redirect()->getTargetUrl();
    }
}
