<?php
/**
 * Created by PhpStorm.
 * User: 黑盒子
 * Date: 2019/11/3
 * Time: 18:43
 */

namespace app\index\model;


use think\Model;

class User extends Model
{
    protected $table='users';
    protected $pk='uid';
    public $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

}