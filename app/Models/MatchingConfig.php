<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchingConfig extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the accessKeys associated with the Account.
     */
    public function fields()
    {
        return $this->hasOne(Fields::class,'id');
    }
}
