<?php


namespace App\Classes;


use Laravel\Socialite\Facades\Socialite;

class Facebook
{
    public function getUrl(){
       return Socialite::driver('facebook')->scopes(['public_profile,pages_show_list,pages_messaging,pages_read_engagement,pages_manage_cta,pages_manage_metadata'])->redirect()->getTargetUrl();
    }
}
