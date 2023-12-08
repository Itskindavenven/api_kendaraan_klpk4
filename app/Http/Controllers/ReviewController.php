<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Car;
use App\Models\User;

class ReviewController extends Controller
{
    public function index()
    {
        $review = Review::all();
        if ($review->isEmpty()) {
            return response()->json(['error' => 'No ratings found'], 404);
        }
        return response()->json([
            "status" => true,
            "message" => 'Berhasil ambil data',
            "data" => $review
        ], 200);
    }

    public function fetchAllForUser($id_user)
    {
        try {
            $user = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => null
                ], 404);
            }

            $review = Review::with('user', 'car')->where('id_user', $id_user)->get();

            if ($review->isNotEmpty()) {
                return response()->json([
                    "status" => true,
                    "message" => 'Berhasil ambil data',
                    "data" => $review
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Review masih kosong',
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
        $request->validate([
            'id_user' => 'required',
            'id_car' => 'required',
            'deskripsi' => 'required'
        ]);

        $car = Car::find($request->id_car);
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $review = Review::create($request->all());
        return response()->json($review, 201);
    }


    public function show($id_user, $id)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $review = Review::find($id);

        if ($review->isEmpty()) {
            return response()->json(['error' => 'Review Not Found'], 404);
        }
        return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil ambil data',
                    'data'=> $review
                ], 200);
    }

    public function update(Request $request,$id_user, $id)
    {
        $review = Review::find($id);

        $user = User::find($id_user);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $request->validate([
            'id_user' => 'required',
            'id_car' => 'required',
            'deskripsi' => 'required'
        ]);

        $review->update($request->all());
         return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $review
            ], 200);
    }

    public function destroy($id)
    {
        try {
            $review = Review::find($id);
    
            if (!$review) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
    
            $review->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }
}