<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    /**
     * Get the accessKeys associated with the Account.
     */
    public function keys()
    {
        return $this->hasMany(Access_keys::class,'account_id');
    }
    public function delete()
    {
        $this->keys()->delete();
        return parent::delete();
    }
}
