<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldsValues extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function contact()
    {
        return $this->belongsTo(Contacts::class,'contact_id');
    }
}
