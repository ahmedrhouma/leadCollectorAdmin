<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responders extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public static function booted()
    {
        static::addGlobalScope('responders_created_user',function (\Illuminate\Database\Eloquent\Builder $builder){
            if (Auth()->check()) {
                $builder->where('account_id', Auth()->user()->account->id);
            }
        });
    }
    /**
     * Get the questions associated with the Responder.
     */
    public function questions()
    {
        if ($this->type == 1) {
            return $this->hasMany(Questions::class, 'responder_id');
        } else {
            return $this->hasOne(Forms::class, 'responder_id');
        }
    }
    /**
     * Get the channels associated with the Responder.
     */
    public function channels()
    {
        return $this->hasMany(Channels::class, 'responder_id');
    }
}
