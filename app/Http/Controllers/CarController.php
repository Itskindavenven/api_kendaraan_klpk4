<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
{
    try {
        $cars = Car::all();
        if ($cars->isNotEmpty()) {
            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data',
                "data" => $cars
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mobil yang ditemukan',
                'data' => null
            ], 500);
        }
    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => $e->getMessage(),
            "data" => []
        ], 400);
    }
}


    public function store(Request $request)
    {
        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    public function show($id)
    {
        try {
            $car = Car::find($id);
            if ($car) {
                return response()->json([
                    "status" => true,
                    "message" => 'Berhasil ambil data',
                    "data" => $car
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Mobil tidak ditemukan',
                    'data' => null
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        if(!$car){
            return response()->json(['message' => 'Car not found'], 404);
        }
        $car->update($request->all());
        return response()->json($car, 200);
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        if(!$car){
            return response()->json(['message' => 'Car not found'], 404);
        }
        $car->delete();
        return response()->json(null, 204);
    }
}
