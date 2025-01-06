<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Queries\VehicleQuery;
use App\Services\Pricing\DefaultPricingStrategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Validator;

class VehicleController extends Controller
{
    public function index(Request $request) {
        return VehicleQuery::apply($request->all())->paginate(10);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:vehicle_categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return parent::return_error(implode(' ', $validator->messages()->all()), 400, $validator->messages()->all()[0]);
        }

        $row = new Vehicle;

        $row->name = $request->name;
        $row->vehicle_category_id =  $request->category_id;
        $row->price_per_day = $request->price;

        if ($request->features) {
            $row ->features = $request->features;
        }

        if ($request->specifications) {
            $row->specifications = $request->specifications;
        }

        if ($request->image) {
            $image_path = parent::store_file('Vehicle', $request->image);
            $row->image = $image_path;
        }

        $row->save();

        // Cache::flush(); 

        return response()->json([
            'status' => 'success',
            'data' => $row,
        ], 201);

    }

    public function calculatePrice(Request $request) {
        $pricing_strategy = new DefaultPricingStrategy();
        $price = $pricing_strategy->calculatePrice(
            $request->price_per_day, 
            $request->days, 
        );

        return response()->json(['price' => $price]);
    }
}
