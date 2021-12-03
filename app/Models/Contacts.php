<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

class Contacts extends Model
{
    use HasFactory;
    const GENDER = [1=>"male",2=>"female"];
    const USERTYPE = [1=>"client",2=>"lead",3=>"competitor"];
    protected $guarded = [
        'id'
    ];
    public function getGenderAttribute($gender){
        return self::GENDER[$gender] ?? null;
    }
    public function getUserTypeAttribute($userType){
        return self::USERTYPE[$userType] ?? null;
    }

    public static function booted()
    {
        static::addGlobalScope('contacts_created_user',function (\Illuminate\Database\Eloquent\Builder $builder){
            if (Auth()->check()) {
                $builder->where('account_id', Auth()->user()->account->id);
            }
        });
    }

    /**
     * Get the field values associated with the Contact.
     */
    public function fields()
    {
        return $this->hasMany(FieldsValues::class,'contact_id');
    }
    /**
     * Get the requests values associated with the Contact.
     */
    public function requests()
    {
        return $this->hasMany(Requests::class,'contact_id');
    }
    /**
     * The segments that belong to the Contact.
     */
    public function Segments()
    {
        return $this->belongsToMany(Segments::class,'contacts_segments', 'contact_id', 'segment_id');
    }
    /**
     * Get the profiles values associated with the Contact.
     */
    public function profiles()
    {
        return $this->hasMany(Profiles::class,'contact_id');
    }
    public function delete()
    {
        $this->fields()->delete();
        return parent::delete();
    }
}
