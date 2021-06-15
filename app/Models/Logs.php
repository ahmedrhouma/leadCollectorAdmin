<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    const elements = [
        1=>"authorization" ,
        2=>"accounts" ,
        3=>"channels" ,
        4=>"contacts" ,
        5=>"fields" ,
         6 => "messages",
        7=>"profiles",
        8=>"requests" ,
        9=>"responders" ,
        10=>"segments"
    ];
    protected $guarded = [
        'id'
    ];
    public function getElementAttribute($element){
        return self::elements[$element];
    }
    /**
     * Get the accessKeys associated with the Account.
     */
    public function keys()
    {
        return $this->hasMany(Access_keys::class,'account_id');
    }
}
