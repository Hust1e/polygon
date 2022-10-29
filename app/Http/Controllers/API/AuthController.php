<?php

namespace App\Http\Controllers\API;

use App\Models\Author;
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
            return $this->fail('', 'Unauthorized Access', 401);
        }
        $user = User::where('email', $request->email)->first();
        if($user->is_admin == 1){
            return  $this->success([
                'user' => $user,
                'token' => $user->createToken("$user->name", ['admin'])->plainTextToken
            ]);
        }
        return  $this->success([
            'user' => $user,
            'token' => $user->createToken('API token for ', ['user'])->plainTextToken
        ]);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        if(is_null($request->is_admin)){
            $request->is_admin = 0;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => HASH::make($request->password),
            'is_admin' => $request->is_admin,
        ]);
        if($user->is_admin == 1){
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('token', ['admin'])->plainTextToken,
            ]);
        }
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('token', [''])->plainTextToken,
        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->success('', 'You have been logged out, and your token has been deleted');
    }
}
