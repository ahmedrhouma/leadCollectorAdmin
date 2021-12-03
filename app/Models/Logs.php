<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Logs extends Model
{
    use HasFactory;
    const elements = [
        1=>"authorization" ,
        2=>"account" ,
        3=>"channel" ,
        4=>"contact" ,
        5=>"field" ,
         6 => "message",
        7=>"profile",
        8=>"request" ,
        9=>"responder" ,
        10=>"segment"
    ];
    const actions = [
        "Add"=>"created" ,
        "Edit"=>"updated" ,
        "Delete"=>"deleted" ,
    ];
    protected $guarded = [
        'id'
    ];
    protected $appends = [
        'actionDesc'
    ];
    public function getElementAttribute($element){
        return self::elements[$element];
    }
    public function getActionDescAttribute(){
        return self::actions[$this->action];
    }
    /**
     * Get the accessKeys associated with the Account.
     */
    public function keys()
    {
        return $this->belongsTo(Access_keys::class,'access_id');
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}
