<?php
/**
 * Created by PhpStorm.
 * User: 黑盒子
 * Date: 2019/11/3
 * Time: 18:43
 */

namespace app\index\model;


use think\Model;
use think\model\concern\SoftDelete;

class Notes extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $table='notes';
    protected $pk='nid';
    public $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

}