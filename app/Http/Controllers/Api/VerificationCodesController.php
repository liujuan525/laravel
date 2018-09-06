<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request -> phone;
        // 4位随机数 左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        // 仅限正式环境才发送真实短信
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            try{
                // 发送短信
                $data['template'] = 'SMS_126360418'; // 模板id
                $data['data'] = ['code'=>$code];
//            $easySms -> send($phone, $data);
            } catch (ClientException $e) {
                return $this ->response->errorInternal($e->getMessage());
            }
        }

        // 缓存验证码 有效期十分钟
        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinutes(10);
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
