<?php

namespace app\index\controller;
header("Access-Control-Allow-Origin: * ");

use think\Request;
use think\Controller;
use think\Session;
use think\Config;

class Index extends Controller
{
    public function index()
    {
		$ip = Request::instance()->ip();
        $wchat = new \wechat\WechatOauth(Config::get('appid'), Config::get('appsecret'));
        $code = request()->param('code', "");
        //$code=$_GET['code'];
        $sjid = request()->param('sjid',"");
        $user = $wchat->getUserAccessUserInfo($code, Config::get('wx_url'). 'index.php/index/index/index/sjid/' . $sjid);
        //print_r($user);
        $data['openid'] = $user['openid'];
        $data['nickname'] = $user['nickname'];
        $data['sex'] = $user['sex'];
        $data['headimgurl'] = $user['headimgurl'];
        $data['logintime'] = time();
        $data['regtime'] = time();
        $data['utid'] = $sjid;
      	$data['ip'] = $ip;
        $user_info = db('user_list')->where('openid', $user['openid'])->find();
        if (empty($user_info['openid'])) {
            $model = db('user_list')->insert($data);
            $user_info = db('user_list')->where('openid', $user['openid'])->find();
            $userid = $user_info['id'];
        }
        $userinfo = db('user_list_kc')->where('openid', $user['openid'])->find();
        if (empty($userinfo['openid'])) {
			$data['id'] = $userid;
            $model = db('user_list_kc')->insert($data);
//            $userinfo = db('user_list_kc')->where('openid', $user['openid'])->find();
//            $kcid = $userinfo['id'];

        }
        $da = db('user_list')->where('openid', $user['openid'])->find();
//        $kaichuan = db('user_list_kc')->where('openid', $user['openid'])->find();
        $userid = $da['id'];
//        $kcid = $kaichuan['id'];
//        Session::set('userid',$userid);
//        Session::set('kcid',$kcid);
//        header("Location:http://" . $_SERVER['HTTP_HOST'] . "/web/");
        header("Location: " . Config::get('web_url') . "index.php/index/index/wx_index?userid=" . $userid); //授权完成跳回主站域名
        exit();
    }
	
	public function wx_index()
    {
		$userid=$_GET['userid'];
        Session::set('userid',$userid);
        //$id = session('userid');

        $status = db('user_list_kc')->where('id', $userid)->find();
        if ($status['status'] == 1) {
           echo "<script>alert('禁止进入游戏,请联系客服');</script>";
        } else {
        
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/web/");
            exit();
        }
	}
}
