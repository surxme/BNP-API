<?php
/**
 * Created by PhpStorm.
 * User: 黑盒子
 * Date: 2019/11/3
 * Time: 18:46
 */

namespace app\index\validate;


use think\Validate;

class Notes extends Validate
{
    protected $rule =   [
        'tittle'=>'require|max:15',
        'content'=>'require',
    ];

    protected $message  =   [
        'tittle.require'=>'标题不能为空',
        'content.require'=>'内容不能为空',
        'tittle.max'=>'标题长度不得超过15',
    ];
}