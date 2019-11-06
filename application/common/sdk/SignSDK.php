<?php
/**
 * Created by PhpStorm.
 * User: 黑盒子
 * Date: 2019/11/6
 * Time: 21:20
 */

namespace app\common\sdk;


use app\common\exception\ApiException;
use think\Exception;

class SignSDK
{
    const KEY = 'IbSJT6NkV0rnQKfQu3lqXPOh85ag30reHR';

    private $sign = '';
    private $salt = '';
    private $sign_time = '';

    public function __construct($sign,$salt,$sign_time)
    {
        $this->sign = $sign;
        $this->salt = $salt;
        $this->sign_time = $sign_time;
    }

    /**
     * @throws ApiException
     */
    public function verifySign(){
        if(empty($this->sign)){
            throw new ApiException([
                'success' => '0',
                'msg' => '缺少签名参数'
            ]);
        }
        if(empty($this->sign_time)){
            throw new ApiException([
                'success' => '0',
                'msg' => '缺少签名时间参数'
            ]);
        }
        if(empty($this->salt)){
            throw new ApiException([
                'success' => '0',
                'msg' => '缺少签名盐值参数'
            ]);
        }
        if ($this->sign != $this->generateSign($this->salt,$this->sign_time)){
            throw new ApiException([
                'success' => '0',
                'msg' => '签名错误'
            ]);
        }
    }

    private function generateSign($salt,$sign_time){
        $sign = md5($salt.$sign_time.self::KEY);
        return $sign;
    }
}