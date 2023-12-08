<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_user)
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

            $carts = Cart::with('user', 'car')->where('id_user', $id_user)->get();

            if ($carts->isNotEmpty()) {
                return response()->json([
                    "status" => true,
                    "message" => 'Berhasil ambil data',
                    "data" => $carts
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Keranjang masih kosong',
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





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_car' => 'required|exists:cars,id_car',
            'carName' => 'required',
            'day' => 'required',
            'price' => 'required',
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'location' => 'required',
        ]);

        try{
            $cart = Cart::create($request->all());
            return response()->json([
                "status" => true,
                "message" => "Berhasil tambah data",
                "data" => $cart
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id_user, $id)
    {
        try{
            $user = User::find($id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => null
                ], 404);
            }

            $carts = Cart::with('user', 'car')->where('id_user', $id_user)->get();
            $cart = Cart::find($id);

            if($cart){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil ambil data',
                    'data'=> $cart
                ], 200);
            }else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $cart = Cart::find($id);

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'id_user' => 'required|exists:users,id',
                'id_car' => 'required|exists:cars,id_car',
                'carName' => 'required|string',
                'day' => 'required|integer',
                'price' => 'required|integer',
                'pickup_date' => 'required|date',
                'return_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $cart->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $cart
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $cart = Cart::find($id);
    
            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
    
            $cart->delete();
    
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