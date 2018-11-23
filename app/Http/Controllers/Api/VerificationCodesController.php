<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    public function store(verificationCodeRequest $request)
    {
        $easysms = app('easysms');
        $phone = $request->phone;
        if(config('app.env') == 'local'){
            $code = '1231';
        }else{
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easysms->send($phone, [
                    'content' => "【Lbbs社区】您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception){
                dd('发送失败');
            }
        }

        $key = 'verificationCode_'.str_random(15);
        $expired = now()->addMinutes(10);
        
        \Cache::put($key, ['phone'=>$phone, 'code'=>$code], $expired);
        
        return $this->response->array([
            'notification_key' => $key,
            'expired_at' => $expired->toDateTimeString()
        ])->setStatusCode(201);
    }
}