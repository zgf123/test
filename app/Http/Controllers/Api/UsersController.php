<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request){
        $verifyData = Cache::get($request->verification_key);
        if(!$verifyData){
            return $this->response->error('验证码失效', 422);
        }

        if($request->verification_code !== $verifyData['code']){
            return $this->response->errorUnauthorize('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        Cache::forget($request->notification_key);

        return $this->response->created();
    }
}
