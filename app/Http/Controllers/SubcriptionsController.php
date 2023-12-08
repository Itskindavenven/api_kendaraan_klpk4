<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\subscriptions;

class SubcriptionsController extends Controller
{
    public function index()
    {
        //coba
        $subcriptions = subscriptions::all();
        if ($subcriptions->isEmpty()) {
            return response()->json(['error' => 'No subscriptions found'], 404);
        }
        return response()->json($subcriptions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'tipe' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
        ]);
    
        $user = User::find($request->id_user);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $subcription = subscriptions::create($request->all());
        return response()->json($subcription, 201);
    }
    
    public function show($id_user)
    {
        $subcriptions = subscriptions::where('id_user', $id_user)->get();
        if ($subcriptions->isEmpty()) {
            return response()->json([
            'message'=> 'User tidak ditemukan',
            'data'=> null
        ], 404);
        }
        return response()->json([
            
                'message'=> 'Berhasil ambil subs',
                'data'=> $subcriptions
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required',
            'tipe' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
        ]);
    
        // $user = User::find($request->id_user);
        // if (!$user) {
        //     return response()->json(['error' => 'User not found'], 404);
        // }
    
        $subcription = subscriptions::find($id);
        $subcription->update($request->all());
        return response()->json($subcription, 200);
    }    

    public function destroy($id)
    {
        try {
            $subs = subscriptions::find($id);
    
            if (!$subs) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                    'data' => null
                ], 404);
            }
    
            $subs->delete();
    
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
            //coba
        }
    }
}
