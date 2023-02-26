<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MongoModel;

class AuthController extends Controller
{
    private MongoModel $tasks;
	public function __construct()
	{
		$this->tasks = new MongoModel('users');
	}

    public function login()
    {
        $credentials = request(['name','password']);
        $token = auth()->attempt($credentials);
        if(!$token){
            return response()->json(['error'=>'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout(){
        auth()->logout();

        return response()->json([
            'message' => 'Berhasil Log Out'
        ], 200);
    }

    public function refresh(){
        return response()->json([
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function data(){
        return response()->json(auth()->user());
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'email'  => 'required',
            'password' => 'required'
        ]);
    
        $data = [
			'name' => $request->post('name'),
			'email'=> $request->post('email'),
            'password'=> bcrypt($request->post('password')),
		];

        $id = $this->tasks->save($data);
		
        if($id) {
            return response()->json([
                'success' => true,
                'message' => 'Anda berhasil melakukan registrasi',
            ], 201);
        } 

        return response()->json([
            'success' => false,
            'message' => 'Anda gagal melakukan registrasi',
        ], 409);
    }
}
