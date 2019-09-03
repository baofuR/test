<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Member extends Controller
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
        $data = db('user_list')->where($where)->order('id desc')->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

//    //代理列表
//    public function dailinum()
//    {
//        $res = db('admin')->where('guanlitype', 2)->order('id desc')->select();
//        foreach ($res as $k => $v) {
//            $tixian = db('tixian')->where('userid',$v['id'])->where('status',2)->where('qubie',1)->sum('jine');
//            $res[$k]['tixian'] = $tixian;
//        }
//        $this->assign('res', $res);
//        return $this->fetch();
//    }
//
//    //删除代理
//    public function admindel($id)
//    {
//        $res = db('admin')->delete($id);
//        if ($res) {
//            $this->redirect(url('admin/member/dailinum'));
//        } else {
//            $this->error('删除失败');
//        }
//    }

    //后台手动上分
    public function edit(Request $request)
    {
        $data = request()->param();
        $arr = [];
        if (!empty($data) && isset($data)) {
            $arr = $data;
        }

        $member = db('user_list')
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
        $utid = db('user_list')->where('id', $id)->field('utid')->find();
        $user = db('admin')->where('id', $utid['utid'])->find();
        if ($user['utid'] !== 0) {
            //一级代理
            $utid1 = db('admin')->where('id', $user['utid'])->find();
            //二级代理
            //$utid2 = db('admin')->where('utid', $utid1['id'])->find();
//            //总佣金
//            $zyj = $yjiajine * $utid1['yjdlbili'] / 100;
//            //二级佣金
//            $dali2 = $zyj * $user['yjdlbili'] / 100;
//            //一级佣金
//            $daili1 = $zyj - $dali2;
//            db('admin')->where('id', $utid1['id'])->setInc('yongjin', $daili1);
//            db('admin')->where('id', $utid1['id'])->setInc('zongyj', $daili1);
//            db('admin')->where('id', $user['id'])->setInc('yongjin', $dali2);
//            db('admin')->where('id', $user['id'])->setInc('zongyj', $dali2);
            if ($utid1['utid'] !== 0) {
                //一级代理
                $utid2 = db('admin')->where('id', $utid1['utid'])->find();
                //总佣金
                $zyj = $yjiajine * $utid2['kcyjdlbili'] / 100;
                //二级佣金
                $dali2 = $zyj * $utid1['kcyjdlbili'] / 100;
                $dali3 = $dali2 * $user['kcyjdlbili'] / 100;

                //一级佣金
                $daili1 = $zyj - $dali2 - $dali3;
                db('admin')->where('id', $utid2['id'])->setInc('yongjin', $daili1);
                db('admin')->where('id', $utid2['id'])->setInc('zongyj', $daili1);

                db('admin')->where('id', $utid1['id'])->setInc('yongjin', $dali2);
                db('admin')->where('id', $utid1['id'])->setInc('zongyj', $dali2);

                db('admin')->where('id', $user['id'])->setInc('yongjin', $dali3);
                db('admin')->where('id', $user['id'])->setInc('zongyj', $dali3);
            } else {
                //总佣金
                $zyj = $yjiajine * $utid1['yjdlbili'] / 100;
                //二级佣金
                $dali2 = $zyj * $user['yjdlbili'] / 100;
                //一级佣金
                $daili1 = $zyj - $dali2;
                db('admin')->where('id', $utid1['id'])->setInc('yongjin', $daili1);
                db('admin')->where('id', $utid1['id'])->setInc('zongyj', $daili1);
                db('admin')->where('id', $user['id'])->setInc('yongjin', $dali2);
                db('admin')->where('id', $user['id'])->setInc('zongyj', $dali2);
            }
        } else {
            $yongjin = $yjiajine * $user['yjdlbili'] / 100;
            db('admin')->where('username', $user['username'])->setInc('yongjin', $yongjin);
            db('admin')->where('username', $user['username'])->setInc('zongyj', $yongjin);
        }

        if ($yjiajine > 0) {
            $data['ddanhao'] = date("YmdHis");
            $data['userid'] = $id;
            $data['jine'] = $yjiajine;
            $data['dtime'] = time();
            $data['ctype'] = 'admin';
            db('user_chongzhi')->insert($data);
            Db::execute("update tp_user_list set balance=balance+$yjiajine where id=$id");
            Db::execute("update tp_user_list set chongzhi=chongzhi+$yjiajine where id=$id");
            $this->redirect('admin/member/memberlist');
        }
        Db::execute("update tp_user_list set balance=balance-$yjianjine where id=$id");
        $this->redirect('admin/member/memberlist');
        exit();
//        print_r($res);
    }

    //禁止用户进入游戏
    public function jinzhigame()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $db = db('user_list')->where('id', $id)->setField('status', $status);
    }

    //解除禁止
    public function jiechu()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $db = db('user_list')->where('id', $id)->setField('status', $status);
    }
  
       //删除用户
    public function userdel($id)
    {
		try{
			$openid_db = db('user_list')->where('id', $id)->field('openid')->find();
			if(!empty($openid_db['openid'])){
				$openid_id = db('user_list_kc')->where('openid', $openid_db['openid'])->find();
			}else{
				$openid_id = db('user_list_kc')->where('id', $id)->find();
			}
			db('user_list_kc')->delete($openid_id['id']);
		}catch(Exception $e){
		}
        $res = db('user_list')->delete($id);
        if ($res) {
            $this->redirect(url('admin/member/memberlist'));
        } else {
            $this->error('删除失败');
        }
    }
       //删除kc用户
    public function userdel_kc($id)
    {
		try{
			$openid_db = db('user_list_kc')->where('id', $id)->field('openid')->find();
			if(!empty($openid_db['openid'])){
				$openid_id = db('user_list')->where('openid', $openid_db['openid'])->find();
			}else{
				$openid_id = db('user_list')->where('id', $id)->find();
			}
			db('user_list')->delete($openid_id['id']);
		}catch(Exception $e){
		}
        $res = db('user_list_kc')->delete($id);
        if ($res) {
            $this->redirect(url('admin/kcmember/memberlist'));
        } else {
            $this->error('删除失败');
        }
    }
}