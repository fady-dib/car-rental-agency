<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_category_id',
        'status',
        'features',
        'specifications',
        'price_per_day',
        'image'
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function getImageAttribute($value){
        return $value ? url($value) : null;
    }

    public function category() {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

}
