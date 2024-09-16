<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'service_id',
        'status',
        'mobile',
    ];

    // Optionally, define the relationship to the Service model
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
