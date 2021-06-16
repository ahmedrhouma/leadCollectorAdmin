<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access_keys extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    public function account()
    {
        return $this->belongsTo(Accounts::class,'account_id');
    }


}
