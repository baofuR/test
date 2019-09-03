<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Clear extends Controller
{
    protected $beforeActionList = [
        'checkLogin' => ['except' => 'login'],
    ];

    // 检测管理员的登录状态
    public function checkLogin()
    {
        if (!session('?admin')) {
            $this->redirect(url('admin/user/login'));
        }
    }

    public function index()
    {
        return $this->fetch();
    }

    public function ajaxclear(Request $request)
    {
        $pwd = request()->param();
        $arr = [];
        if (!empty($pwd) && isset($pwd)) {
            $arr = $pwd;
        }
        //print_r($arr);
        $upass1 = md5($arr['password']);
        $adminid = session("admin");
        $user = db("admin")->where('id', $adminid['id'])->find();
        //print_r($user);
        if ($user["password"] == $upass1) {
            Db::execute('truncate tp_user_chongzhi');
            Db::execute('truncate tp_user_chongzhi_kc');
         Db::execute("update tp_user_list_kc set chongzhi=0");
            $this->success('操作成功', 'index');
        }
    }
  public function ajaxtxclear(Request $request)
    {
        $pwd = request()->param();
        $arr = [];
        if (!empty($pwd) && isset($pwd)) {
            $arr = $pwd;
        }
        //print_r($arr);
        $upass1 = md5($arr['password']);
        $adminid = session("admin");
        $user = db("admin")->where('id', $adminid['id'])->find();
        //print_r($user);
        if ($user["password"] == $upass1) {
            Db::execute('truncate tp_tixian');
            Db::execute('truncate tp_tixian_kc');
          Db::execute("update tp_user_list_kc set zongtx=0");
            $this->success('操作成功', 'index');
        }
    }
  public function ajaxcsclear(Request $request)
    {
        $pwd = request()->param();
        $arr = [];
        if (!empty($pwd) && isset($pwd)) {
            $arr = $pwd;
        }
        //print_r($arr);
        $upass1 = md5($arr['password']);
        $adminid = session("admin");
        $user = db("admin")->where('id', $adminid['id'])->find();
        //print_r($user);
        if ($user["password"] == $upass1) {
            Db::execute('truncate tp_xiazhujilu_kc');
   
            $this->success('操作成功', 'index');
        }
    }
  public function ajaxxfclear(Request $request)
    {
        $pwd = request()->param();
        $arr = [];
        if (!empty($pwd) && isset($pwd)) {
            $arr = $pwd;
        }
        //print_r($arr);
        $upass1 = md5($arr['password']);
        $adminid = session("admin");
        $user = db("admin")->where('id', $adminid['id'])->find();
        //print_r($user);
        if ($user["password"] == $upass1) {
            Db::execute('truncate tp_admin_xiafen');
     
            $this->success('操作成功', 'index');
        }
    }
}