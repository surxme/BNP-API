<?php
namespace app\index\controller;

use app\common\sdk\SignSDK;
use app\index\model\Notes;
use app\index\model\User;
use think\Controller;
use think\exception\HttpException;
use think\facade\App;

class Index extends Controller
{
    protected $beforeActionList = [
        'verifySign'
    ];

    /**
     * @throws \app\common\exception\ApiException
     */
    protected function verifySign(){
        $sign = input('sign','');
        $sign_time = input('sign_time','');
        $salt = input('salt','');

        $sign_sdk = new SignSDK($sign,$salt,$sign_time);
        $sign_sdk->verifySign();
    }

    public function reg(){
        $data['uname'] = input('uname');
        $data['password'] = input('password');
        $data['clientid'] = input('clientid',"机型错误");
        $data['gender'] = input('gender','0');
        $data['telphone'] = input('telphone','未填写');
//        $data['birthday'] = input('birthday');
        $data['birthday'] = date('y-m-d');
        $data['email'] = input('email','未填写');
        $data['pic'] = "images/default/logo_notepad.png";
        $user = new User();

        $validate = $this->validate($data,'app\index\validate\User');

        if (true !== $validate) {
            // 验证失败
            $over['success']='0';
        }else{
            $data['password']=md5($data['password']);
            $res = $user->save($data);
            if($res){
                $over['success']='1';
            }else{
                $over['success']='0';
            }
        }

        return json($over);
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login(){
        $uname = input('uname');
        $password = input('password');
        $password = md5($password);

        $user=User::where('uname',$uname)->find();

        $over=[
            'success' => '0'
        ];

        if($user){
            if($password == $user['password']){
                $over['success'] = $user['uid'];
            }
        }
        return json($over);
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $uid=input('uid');
        $notes=Notes::where('uid',$uid)->order('nid','desc')->select();
        return json($notes);
    }

    public function getNote(){
        $nid=input('nid');
        $result=Notes::get($nid);
        return json($result);
    }

    public function uploads(){
        $data['uid'] = input('uid');
        $data['tittle'] = input('tittle');
        $data['content'] = input('content');

        $validate = $this->validate($data,'app\index\validate\Notes');

        if (true !== $validate) {// 验证失败
            $over['success']='0';
        }else {
            $notes = new Notes();
            $result = $notes->save($data);
            if ($result) {
                $over['success'] = '1';
            } else {
                $over['success'] = '0';
            }
        }

        return json($over);
    }

    public function edit(){
        $tid=input('nid');
        $type=Notes::get($tid);
        return json($type);
    }

    public function noteupdate(){
        $nid = input('nid');
        $data['tittle'] = input('tittle');
        $data['content'] = input('content');

        $validate = $this->validate($data,'app\index\validate\Notes');

        if (true !== $validate) {// 验证失败
            $over['success']='0';
        }else {
            $notes = new Notes();
            $result = $notes->save($data,['nid' => $nid]);
            if ($result) {
                $over['success'] = '1';
            } else {
                $over['success'] = '0';
            }
        }
        return json($over);
    }

    public function notedel(){
        $id=input('nid');
        $res = Notes::destroy($id);
        if($res){
            $date=['success' => "1"];
        }else{
            $date=['success' => "0"];
        }
        return json($date);
    }

    public function getUserInfo(){
        $uid = input('uid');
        $result = User::where('uid',$uid)->field('uid,clientid,uname,telphone,gender,birthday,pic,email')->find();
        if($result){
            $result = array_merge(['success' => "1"],$result->getData());
            return json($result);
        }else{
            $over['success']='0';
            return json($over);
        }
    }

    public function updateUser(){
        $uid = input('uid');
        $data['uname'] = input('uname');
        $data['gender'] = input('gender');
        $data['telphone'] = input('telphone','未填写');
        $data['email'] = input('email',"未填写");

        $validate = $this->validate($data,'app\index\validate\User');

        if (true !== $validate) {// 验证失败
            $over['success']='0';
            $over['msg'] = $validate;
        }else {
            $user = new User();
            $result = $user->save($data,['uid' => $uid]);
            if ($result) {
                $over['success'] = '1';
            } else {
                $over['success'] = '0';
                $over['msg'] = '更新失败';
            }
        }

        return json($over);
    }

    public function changePass(){
        $uid = input('uid');
        //原密码
        $password = input('password');
        $password = md5($password);
        //新密码
        $data['password'] = input('newpass');
        $data['password'] = md5($data['password']);

        $exist=User::where('uid',$uid)->where('password',$password)->count();

        $over = ['success' => '0'];
        if($exist){
            $user = new User();
            $result=$user->save($data,['uid'=>$uid]);
            if($result){
                $over['success']='1';
            }
        }

        return json($over);
    }

    public function updatePortait(){
        $img = input('portrait');
        $data['pic'] = $img;
        $id = input('uid');
        $exist = User::get($id);
        if($exist){
            $exc = User::where('uid',$id)->update($data);
            if($exc) {
                $result = array("success" => '1');
            } else{
                $result = array("success" => '0');
            }
        }else{
            $result = array("success" => '0');
        }
        return json($result);
    }

    public function getVersion(){
        echo phpversion();
    }
    public function feedback(){
        $data['uid'] = input('uid');
        $data['content'] = input('feedback');

        $result=db('feedback')->insert($data);
        $over = ['success' => '0'];
        if($result){
            $over['success']='1';
            return $over;
        }

        return json($over);
    }

    public function getServerIP(){
        $IpSet['ip'] = 'http://bnp.zzylx.top/notepadapi/';
        return json($IpSet);
    }

    public function upload(){
        $file = request()->file('uploaded_file');
        $res = ["success" => 0];

        if($file){
            $info = $file->rule('uniqid')->move(App::getRootPath().'/public/static/portrait');
            if ($info) {//上传成功
                $file_name = $info->getFilename();
                $file_url = 'http://bnp.zzylx.top/static/portrait/' . $file_name;
                $res["success"] = $file_url;
            }
        }

        return json($res);
    }
}
