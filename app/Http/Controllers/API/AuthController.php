<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials)) {
            return $this->fail('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return  $this->succsess([
            'user' => $user,
            'token' => $user->createToken('API token for ' . $user->name)->plainTextToken
        ]);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => HASH::make($request->password),
        ]);
        return $this->succsess([
            'user' => $user,
            'token' => $user->createToken('You personal Token')->plainTextToken,
        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->succsess('', 'You have been logged out, and your token has been deleted');
    }
}
