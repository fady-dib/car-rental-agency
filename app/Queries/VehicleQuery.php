<?php

namespace App\Queries;

use App\Models\Vehicle;

class VehicleQuery {
    public static function apply($filters) {
        $query = Vehicle::select([
            "id",
            "name",
            "vehicle_category_id",
            "features",
            "specifications",
            "price_per_day",
            "image",
        ])
        ->where('status', 'available')
        ->with(['category'=>function($query){
            $query->select([
                'id',
                'name'
            ]);
        }]);

        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['category'] . '%');
            });
        }

        if (!empty($filters['price_min']) && !empty($filters['price_max'])) {
            $query->whereBetween('price_per_day', [$filters['price_min'], $filters['price_max']]);
        }

        if (!empty($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['order'] ?? 'asc');
        }

        return $query;
    }
}
