<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;
    const GENDER = [1=>"male",2=>"female"];
    const USERTYPE = [1=>"client",2=>"lead",3=>"competitor"];
    protected $guarded = [
        'id'
    ];
    public function getGenderAttribute($gender){
        return self::GENDER[$gender];
    }
    public function getUserTypeAttribute($userType){
        return self::USERTYPE[$userType];
    }
    /**
     * Get the field values associated with the Contact.
     */
    public function fields()
    {
        return $this->hasMany(FieldsValues::class,'contact_id');
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
