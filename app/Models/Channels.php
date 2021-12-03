<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the accessKeys associated with the channel.
     */
    public function media()
    {
        return $this->belongsTo(Medias::class,'media_id');
    }
    /**
     * Get the authorization associated with the channel.
     */
    public function authorization()
    {
        return $this->belongsTo(Authorizations::class,'authorization_id');
    }
    /**
     * Get the profiles associated with the channel.
     */
    public function profiles()
    {
        return $this->hasMany(Profiles::class,'channel_id');
    }
    /**
     * Get the responder associated with the channel.
     */
    public function responder()
    {
        return $this->belongsTo(Responders::class,'responder_id');
    }
    /**
     * Get the requests associated with the channel.
     */
    public function requests()
    {
        return $this->hasMany(Requests::class,'channel_id');
    }
    /**
     * Get the account associated with the channel.
     */
    public function accounts()
    {
        return $this->belongsTo(Accounts::class,'account_id');
    }
}
