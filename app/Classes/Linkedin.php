<?php


namespace App\Classes;

use Laravel\Socialite\Facades\Socialite;

class Linkedin
{
    public function getUrl(){
        return Socialite::driver('linkedin')->redirect()->getTargetUrl();
    }
}
