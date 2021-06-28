<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the accessKeys associated with the Account.
     */
    public function media()
    {
        return $this->belongsTo(Medias::class,'media_id');
    }
}
