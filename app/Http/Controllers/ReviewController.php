<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller{
    
    public function index(){
        try{
            $review = Review::all();
            return response()->json([
                "message"=> 'Berhasil ambil data',
                'data'=> $review
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function showAllByUser($id_user){
        try{
            $user = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => null
                ], 404);
            }
            $review = Review::where('id_user', $id_user)->get();
            return response()->json([
                "message"=> 'Berhasil ambil data',
                'data'=> $review
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function store(Request $request){
        $request->validate([
            'id_user' => 'required',
            'id_car' => 'required',
            'komentar' => 'required',
            'nilai' => 'required'
        ]);

        $user = User::find($request->id_user);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $car = Car::find($request->id_car);
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        try{
            $review = Review::create($request->all());
            return response()->json([
                "status" => true,
                "message" => "Berhasil tambah data",
                "data" => $review
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    public function show($id){
        $reviews = Review::where('id_car', $id)->get();
        if ($reviews->isEmpty()) {
            return response()->json(['error' => 'No reviews found for this car ID'], 404);
        }
        return response()->json($reviews);
    }

    public function update(Request $request, $id){
        try {
            $review = Review::find($id);
    
            if (!$review) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
    
            $validator = Validator::make($request->all(), [
                'id_user' => 'required',
                'id_car' => 'required',
                'komentar' => 'required',
                'nilai' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $review->update($request->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $review
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    public function destroy($id){
        try {
            $review = Review::find($id);
    
            if (!$review) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
            print("sampe siniiii");
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