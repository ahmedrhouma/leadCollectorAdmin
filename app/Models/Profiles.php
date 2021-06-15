<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the Contact associated with the Profile.
     */
    public function contact()
    {
        return $this->belongsTo(Contacts::class,'contact_id');
    }
}
