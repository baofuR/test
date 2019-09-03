<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Ptaiconfig extends Controller
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

    public function save()
    {
        $data = db('config')->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function saveconfig(Request $request)
    {
        $arr = request()->param();
        $data = [];
        if (!empty($arr) && isset($arr)) {
            $data = $arr;
        }
        $m = db('config')->find();
        $res = db('config')->where('id', $m['id'])->update($data);
        //print_r($res);
        $this->success('操作成功', 'save');
    }
	
	public function stop()
	{
        $status = request()->param('v');
        $res = db('config')->where('id', 1)->setField('stopxiazhu',$status);
        if ($res){
           $this->redirect(url('admin/ptaiconfig/save'));
       }else{
          $this->error('操作失败');
    }
}
}