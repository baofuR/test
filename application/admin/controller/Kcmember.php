<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Kcmember extends Controller
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

    public function memberlist(Request $request)
    {
        $res = $_POST;
        $where = [];
        if (!empty($res) && isset($res)) {
            $where = $res;
        }
      	$desc = request()->param('sort');
        if (!empty($desc)) {
            $order = $desc . " desc";
        } else {
            $order = "id desc";
        }
        $data = db('user_list_kc')
            ->where($where)
            ->order($order)
            ->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function viewxiazhu($id)
    {
        $data = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('b.userid',$id)
          ->order('b.id desc')
            ->paginate(20);
        $this->assign('data',$data);
        return $this->fetch();
    }

    //代理列表
    public function dailinum()
    {
        $res = db('admin')->where('guanlitype', 3)->order('id desc')->select();
        foreach ($res as $k => $v) {
            $tixian = db('tixian_kc')->where('userid', $v['id'])->where('status', 2)->where('qubie', 1)->sum('jine');
            $res[$k]['tixian'] = $tixian;
        }
        $this->assign('res', $res);
        return $this->fetch();
    }

    //删除代理
    public function admindel($id)
    {
        $res = db('admin')->delete($id);
        if ($res) {
            $this->redirect(url('admin/kcmember/dailinum'));
        } else {
            $this->error('删除失败');
        }
    }

    //后台手动上分
    public function edit(Request $request)
    {
        $data = request()->param();
        $arr = [];
        if (!empty($data) && isset($data)) {
            $arr = $data;
        }

        $member = db('user_list_kc')
            ->where('id', $arr['id'])
            ->field('id,balance')
            ->find();
        $this->assign('member', $member);
        return $this->fetch();
    }

    public function save(Request $request)
    {
        $res = request()->param();
        $arr = [];
        if (!empty($res) && isset($res)) {
            $arr = $res;
        }
        $id = $arr['id'];
        $yjiajine = $arr['jiajine'];
        $yjianjine = $arr['jianjine'];
        if ($yjiajine > 0) {
            $data['ddanhao'] = date("YmdHis");
            $data['userid'] = $id;
            $data['jine'] = $yjiajine;
            $data['dtime'] = time();
            $data['ctype'] = 'admin';
          $data['status'] = 1;
            db('user_chongzhi_kc')->insert($data);
            Db::execute("update tp_user_list_kc set balance=balance+$yjiajine where id=$id");
            Db::execute("update tp_user_list_kc set chongzhi=chongzhi+$yjiajine where id=$id");
            $this->redirect('admin/kcmember/memberlist');
        }elseif ($yjianjine > 0){
            $data['ddanhao'] = date("YmdHis");
            $data['userid'] = $id;
            $data['jine'] = $yjianjine;
            $data['dtime'] = time();
            db('admin_xiafen')->insert($data);
            Db::execute("update tp_user_list_kc set balance=balance-$yjianjine where id=$id");
            $this->redirect('admin/kcmember/memberlist');
        }
    }

    //禁止进入游戏
    public function jinzhigame()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $db = db('user_list_kc')->where('id', $id)->setField('status', $status);
    }

    //解除限制
    public function jiechu()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $db = db('user_list_kc')->where('id', $id)->setField('status', $status);
    }

    public function viewinfo($id)
    {
        $user = db('user_list_kc')->where('id',$id)->find();
        //总下注
        $xiazhu = db('xiazhujilu_kc')->where('userid',$id)->sum('xiazhuzong');
        //总增加
        $zengjia = db('xiazhujilu_kc')->where('userid',$id)->sum('zengjia');
        //输赢
        $win = $zengjia - $xiazhu;
        $data = [
            'zchongzhi' => $user['chongzhi'],
            'ztixian' => $user['zongtx'],
            'zxiazhu' => $xiazhu,
            'win' => $win
        ];
        $this->assign('data',$data);
        return $this->fetch();
    }
}