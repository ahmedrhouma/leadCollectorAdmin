<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the field associated with the Question.
     */
    public function field()
    {
        return $this->belongsTo(Fields::class,'field_id');
    }
}
