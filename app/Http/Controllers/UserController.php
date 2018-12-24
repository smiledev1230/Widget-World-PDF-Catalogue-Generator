<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        return json_encode($request->user());
    }

    public function login(Request $request)
    {
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        if (Auth::attempt($request->only(['email', 'password', 'access_to_widget']))) {
            $status = 200;
            $user = Auth::user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = [
                'user' => $user,
                'token'=> $token
            ];
        }

        return response()->json($response, $status);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);
        $user = User::where('remember_token', $request->get('token'))->update($data);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()
            ->json([
                'logout' => true
            ]);
    }
}
