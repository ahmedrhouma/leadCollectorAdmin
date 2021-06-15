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

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwner($query)
    {
        return $query->where('account_id', '=', intval(\Session::get('account_id')));
    }
    public function account()
    {
        return $this->belongsTo(Accounts::class,'account_id');
    }

}
