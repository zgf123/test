<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request){
        $phone = $request->phone;

        $builder = new CaptchaBuilder();
        $builder->build();

        $key = 'captcha_'.str_random(10);
        $val = [
            'phone' => $phone,
            'captchar_img' => $builder->getPhrase()
        ];
        $expired = now()->addMinutes(2);

        \Cache::put($key, $val, $expired);

        return $this->response->array([
            'captcha_key' => $key,
            'captcha_expired_at' => $expired->toDateTimeString(),
            'captcha_img' => $builder->inline()
        ]);
    }
}
