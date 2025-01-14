<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function booking()
    {
        return $this->hasMany(ProgramBooking::class);
    }
}
