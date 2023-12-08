<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try{
            $user = User::all();
            return response()->json([
                "status"=> true,
                "message"=> 'Berhasil ambil data',
                'data'=> $user
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required',
        // 'email' => 'required|email',
        // 'password' => 'required',
        // 'noTelp' => 'required',
        // 'tglLahir' => 'required',
        // 'image' => 'required'
    ]);

    try{
        $user = User::create($request->all());
        return response()->json([
            'status'=> true,
            'message'=> 'Berhasil register',
            'data'=> $user
        ], 200);
    }catch(\Exception $e){
        return response()->json([
            'status'=> false,
            'message'=> $e->getMessage(),
            'data'=> []
        ], 400);
    }
}

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try{
            $loginData = $request->all();
            $user = User::where('username', $loginData['username'])->where('password', $loginData['password'])->first();
            if($user){
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil login',
                    'data' => $user
                ], 200);
            }else{
                return response()->json([
                    'status'=> false,
                    'message'=> 'Gagal Login',
                    'data'=> []
                ], 400);
            }

        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
        
    }


    public function validasi(Request $request)
    {
        try{
            $validasi = $request->all();
            $user = User::where('email', $validasi['email'])->first();
            if($user){
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil validasi',
                    'data' => $user
                ], 200);
            }else{
                return response()->json([
                    'status'=> false,
                    'message'=> 'Gagal validasi',
                    'data'=> []
                ], 400);
            }

        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
        
    }

    
    public function show($id)
    {
        try{
            $user = User::find($id);

            if(!$user) throw new \Exception('User tidak ditemukan');

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil ambil data user',
                'data'=> $user
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $user = User::find($id);

            if(!$user) throw new \Exception('User tidak ditemukan');

            $user->update($request->all());

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil update data user',
                'data'=> $user
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function updateImage(Request $request, $id)
    {
        try{
            $user = User::find($id);

            if(!$user) throw new \Exception('User tidak ditemukan');

            $user->update($request->only('image'));

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil update data user',
                'data'=> $user
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function destroy($id)
    {
        try{
            $user = User::find($id);

            if(!$user) throw new \Exception('User tidak ditemukan');

            $user->delete();

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil delete data user',
                'data'=> $user
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    public function updateProfile(Request $request, $email)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 400);
        }
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null,
            ], 404);
        }
        try {
            //create new image name to be saved
            $newImageName = $email  . "." . $request->image->extension();

            //move image to public/profiles
            $request->image->move(public_path('profiles'), $newImageName);

            //update profile_path in database
            $user->update(['image' => $newImageName]);
            return response([
                'message' => 'Success',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error when saving image to database',
                'data' => null,
            ], 400);
        }
    }

    public function getProfile($email){
        $user = User::where('email', $email)->first();
        if(is_null($user)){
            return response([
                'message' => 'User not found',
                'data' => null
            ], 404);
        }
        return response()->file(public_path('profiles/').$user['image']);
    }


}
