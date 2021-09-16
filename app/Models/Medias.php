<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medias extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the requests associated with the channel.
     */
    public function channels()
    {
        return $this->hasMany(Channels::class,'media_id');
    }
    public function requests()
    {
        return $this->hasManyThrough(Requests::class, Channels::class,'media_id','channel_id');
    }
}
