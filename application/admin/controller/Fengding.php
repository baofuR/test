<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Fengding extends Controller
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

    public function showfd()
    {
        $data = db('fengding_set')->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function saveset(Request $request)
    {
        $arr = request()->param();
        $data = [];
        if (!empty($arr) && isset($arr)) {
            $data = $arr;
        }
        $m = db('fengding_set')->find();
        $res = db('fengding_set')->where('id', $m['id'])->update($data);
        //print_r($res);
        $this->success('操作成功', 'showfd');
    }
}