<?php
/**
 * Created by PhpStorm.
 * User: 黑盒子
 * Date: 2019/11/3
 * Time: 18:46
 */

namespace app\index\validate;


use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'name'  => 'require|max:25|unique:users',
        'password'=>'require|min:6|max:12'
    ];

    protected $message  =   [
        'uname.unique'      => '用户名已存在',
        'uname.max'         => '用户名可输入最大长度为12',
        'uname.require'     => '用户名不能为空',
        'password.require'  => '密码不能为空',
        'password.max'      => '密码长度不能超过12位',
        'password.min'      => '密码长度不能少于6位'
    ];
}