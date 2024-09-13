<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apparel extends Model
{
    use HasFactory;

    protected $table = 'apparel';

    // Define the relationship to the Type model
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
