<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budget';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'user_id',      // Add this line
        'category_id',
        'title',
        'amount',
        'date',
        'remarks',
        'event_id',
        'apparel_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];


    // Define the relationship to the category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define the relationship to the event model
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Define the relationship to the apparel model
    public function apparel()
    {
        return $this->belongsTo(Apparel::class, 'apparel_id');
    }
}
