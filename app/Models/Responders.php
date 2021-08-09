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

    /**
     * Get the questions associated with the Responder.
     */
    public function questions()
    {
        if ($this->type == 2) {
            return $this->hasMany(Questions::class, 'responder_id');
        } else {
            return $this->hasOne(Forms::class, 'responder_id');
        }
    }
}
