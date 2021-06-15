<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segments extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the contacts values associated with the Segment.
     */
        public function contacts()
    {
        return $this->belongsToMany(Contacts::class,'contacts_segments', 'segment_id', 'contact_id');
    }
}
