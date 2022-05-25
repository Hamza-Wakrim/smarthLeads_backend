<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'username' => 'required|max:255',
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        return response(['user' => $user]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. Try again'],422);
        }

        $user = auth()->user();

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'token' => $token]);
    }
}
