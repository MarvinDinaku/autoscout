<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomePageController extends Controller
{

    public function index()
    {
        try {

            $cars = Car::where('active',1)->get();
            return response()->json($cars);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching car listings.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json($car);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Car not found.'], 404);
        }
    }
}
