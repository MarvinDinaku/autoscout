<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarsController extends Controller
{
    public function index()
    {
        try {
            $cars = Car::all();
            return response()->json($cars);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching car listings.'], 500);
        }
    }

    public function store(Request $request)
    {
//        try {
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string', // Added model type validation
            'engine_size' => 'required|numeric',
            'price' => 'required|numeric',
            'registration_date' => 'required|date', // Added registration date validation
            // Add validation rules for other fields
        ]);

        $car = Car::create($request->all());
        return response()->json($car, 201);
//        } catch (\Exception $e) {
//            return response()->json(['error' => 'An error occurred while creating a new car.'], 500);
//        }
    }

    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json($car);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Car not found.'], 404);
        }
    }

    public function edit($id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json($car);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Car not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'brand' => 'required|string',
                'model' => 'required|string', // Added model type validation
                'engine_size' => 'required|numeric',
                'price' => 'required|numeric',
                'registration_date' => 'required|date', // Added registration date validation
                // Add validation rules for other fields
            ]);

            $car = Car::findOrFail($id);

            $car->update($request->only(['brand', 'model', 'engine_size', 'price', 'registration_date', 'description']));

            return response()->json($car, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the car.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the car.'], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->active = !$car->active;
            $car->save();
            return response()->json($car, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the car status.'], 500);

        }
    }
}
