<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

/**
 *
 */
class Index extends Controller
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
        $admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
        //print_r($data);
        /*$wtx1 = db('tixian')->where('status', 1)->count();
        $w = Db::table('tp_admin')
            ->alias('a')
            ->join('tp_tixian b', 'a.id = b.userid')
            ->where('a.guanlitype', 2)
            ->where('b.status', 1)
            ->count();
        $wtx2 = db('tixian_kc')->where('status', 1)->count();
        $wtx = $wtx1 + $wtx2 + $w;
        $this->assign('wtx', $wtx);*/
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function welcome()
    {
		$wtx1 = db('tixian')->where('status', 1)->count();
        $wtx2 = db('tixian_kc')->where('status', 1)->count();
        $wtx = $wtx1 + $wtx2;
        $this->assign('wtx1', $wtx1);
        $this->assign('wtx2', $wtx2);
        $this->assign('wtx', $wtx);
        return $this->fetch();
    }
}