<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st/gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::group('notepadapi',function (){
    //获取笔记列表
    Route::any('index','Index/index') ;
    //获取单个笔记详情
    Route::any('getnote','Index/getNote') ;
    //保存新笔记
    Route::any('uploads','Index/uploads') ;
    //修改头像
    Route::any('updtportrait','Index/updatePortait') ;
    //更新笔记
    Route::any('update','Index/noteupdate') ;
    //删除笔记
    Route::any('del','Index/notedel') ;
    //用户注册
    Route::any('reg','Index/reg');
    //用户登录
    Route::any('login','Index/login');
    //获取用户信息
    Route::any('getuser','Index/getUserInfo');
    //更新用户信息
    Route::any('updtuser','Index/updateUser');
    //修改用户密码
    Route::any('changepass','Index/changePass');
    //用户上传反馈
    Route::any('feedback','Index/feedback');
    //获取当前php版本
    Route::any('get_V','Index/getVersion');
    //获取当前使用的ip地址
    Route::any('getip','Index/getServerIP');
    Route::any('upload','Index/upload');
});
