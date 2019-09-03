<?php 
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Roompwd extends Controller{
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

    public function showpwd()
    {
        $data = db('roompwd')->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function savepwd(Request $request)
    {
        $arr = request()->param();
        $data = [];
        if (!empty($arr) && isset($arr)) {
            $data = $arr;
        }
        $m = db('roompwd')->find();
        $res = db('roompwd')->where('id', $m['id'])->update($data);
        //print_r($res);
        $this->success('操作成功');
    }
}