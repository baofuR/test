<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
class Record extends Controller
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

    //3.8每日下注记录
    public function recordlist()
    {
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
        $kstime = date("Y-m-d H:i:s", $start_time);
        $jstime = date("Y-m-d H:i:s", $end_time);
        $data = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_xiazhujilu b', 'a.id = b.userid')
            ->where('time', 'between', [$kstime, $jstime])
            ->field('a.nickname,b.*')
            ->order('time desc')
            ->paginate(20);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //北京赛车大众房每日下注记录
    public function kcrecordlist()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
     	 $now = time();
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
        $time = strtotime('-1 day', $now);
        $yesbeginTime = strtotime(date('Y-m-d 00:00:00', $time));
       	$yesendTime = strtotime(date('Y-m-d 00:00:00', $now));
        $data = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('time', 'between', [$yesbeginTime, $end_time])
            ->where($where)
          	->where('b.roomid',0)
            ->field('a.nickname,b.*')
            ->order('time desc')
            ->paginate(20,false,['query'=>request()->param()]);
        $this->assign('data', $data);
        return $this->fetch();
    }
	    //北京赛车约局每日下注记录
    public function kcyjrecordlist()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
     	 $now = time();
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
        $time = strtotime('-1 day', $now);
        $yesbeginTime = strtotime(date('Y-m-d 00:00:00', $time));
       	$yesendTime = strtotime(date('Y-m-d 00:00:00', $now));
        $data = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('time', 'between', [$yesbeginTime, $end_time])
            ->where($where)
          	->where('b.roomid',1)
            ->field('a.nickname,b.*')
            ->order('time desc')
            ->paginate(20,false,['query'=>request()->param()]);
        $this->assign('data', $data);
        return $this->fetch();
    }
  
  	    //北京赛车VIP每日下注记录
    public function kcviprecordlist()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
     	 $now = time();
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
        $time = strtotime('-1 day', $now);
        $yesbeginTime = strtotime(date('Y-m-d 00:00:00', $time));
       	$yesendTime = strtotime(date('Y-m-d 00:00:00', $now));
        $data = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('time', 'between', [$yesbeginTime, $end_time])
            ->where($where)
          	->where('b.roomid',2)
            ->field('a.nickname,b.*')
            ->order('time desc')
            ->paginate(20,false,['query'=>request()->param()]);
        $this->assign('data', $data);
        return $this->fetch();
    }
    //充值记录
    public function chongzhilist()
    {
        $data = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_user_chongzhi b', 'a.id = b.userid')
            ->field('a.id,a.nickname,a.headimgurl,b.ddanhao,b.jine,b.ctype,b.dtime')
            ->order('dtime desc')
            ->paginate(10);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function kcchongzhilist()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
        $data = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_user_chongzhi_kc b', 'a.id = b.userid')
            ->where($where)
            ->field('a.nickname,a.headimgurl,b.*')
            ->order('dtime desc')
            ->paginate(10,false,['query'=>request()->param()]);
        $this->assign('data', $data);
        return $this->fetch();
    }
  	public function querensf($id)
    {
        $jine = db('user_chongzhi_kc')->where('id', $id)->find();
        $money = $jine['jine'];
        $userid = $jine['userid'];
        if ($money > 0) {
            $affected = Db::execute("update tp_user_list_kc set balance=balance+$money,chongzhi=chongzhi+$money where id=$userid");
            if ($affected == 1) {
                db('user_chongzhi_kc')->where('id', $id)->setField('status', 1);
                $this->redirect(url('admin/record/kcchongzhilist'));
            }
        }
    }
    public function deldingdan($id)
    {
        $res = db('user_chongzhi_kc')->delete($id);
        if ($res == 1){
            $this->redirect(url('admin/record/kcchongzhilist'));
        }
    }
    //代理提现记录
    public function dltixian()
    {
        $data = Db::table('tp_admin')
            ->alias('a')
            ->join('tp_tixian b', 'a.id = b.userid')
            ->where('b.qubie', 1)
            ->field('a.id,a.username,a.tixianma,b.*')
            ->order('time desc')
            ->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //确认提现
    public function dlquerentx()
    {
        $id = $_GET['id'];
        $res = db('tixian')->where('id', $id)->setField('status', 2);
    }
      //代理最新提现
    public function newdltx()
    {
        $num = Db::name('tixian')->where('time', '>', time() - 10)->where('qubie', 1)->count();
        if ($num > 0) {
            return json(['status' => 1]);
        } else {
            return json(['status' => 0]);
        }
    }
  
    //最新下分
    public function newtxrecord()
    {
        $num = Db::name('tixian_kc')->where('time', '>', time() - 10)->count();
        if ($num > 0) {
            return json(['status' => 1]);
        } else {
            return json(['status' => 0]);
        }
    }

    //最新上分
    public function newczrecord()
    {
        $num = Db::name('user_chongzhi_kc')->where('dtime', '>', time() - 10)->count();
        if ($num > 0) {
            return json(['status' => 1]);
        } else {
            return json(['status' => 0]);
        }
    }

    //3.8用户提现记录
    public function usertixian()
    {
        $data = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_tixian b', 'a.id = b.userid')
            ->where('b.qubie', 2)
            ->field('a.id,a.nickname,a.tixianma,b.*')
            ->order('time desc')
            ->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //3.8用户确认提现
    public function userquerentx()
    {
        $id = $_GET['id'];
        $res = db('tixian')->where('id', $id)->setField('status', 2);
    }

    //大吃小用户提现记录
    public function kcusertixian()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
        $arr = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_tixian_kc b', 'a.id = b.userid')
            ->where($where)
            ->where('b.qubie', 2)
            ->field('a.id,a.nickname,a.tixianma,b.*')
            ->order('time desc')
            ->paginate(7,false,['query'=>request()->param()]);
        $this->assign('arr', $arr);
        //print_r($arr);
        return $this->fetch();
    }

    //大吃小确认提现
    public function kcquerentx()
    {
        $id = $_GET['id'];
        $res = db('tixian_kc')->where('id', $id)->setField('status', 2);
    }

    //下分记录
    public function xiafen()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.userid'] = $keywords;
        }
        $arr = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_admin_xiafen b', 'a.id = b.userid')
            ->where($where)
            ->field('a.id,a.nickname,b.*')
            ->order('b.dtime desc')
            ->paginate(20,false,['query'=>request()->param()]);
        $this->assign('data', $arr);
        //print_r($arr);
        return $this->fetch();
    }

    //减代理佣金
    public function jianyj()
    {
        $keywords = request()->param('keywords');
        $where = [];
        if (!empty($keywords) && isset($keywords)) {
            $where['b.adminid'] = $keywords;
        }
        $arr = Db::table('tp_admin')
            ->alias('a')
            ->join('tp_xia_yongjin b', 'a.id = b.adminid')
            ->where($where)
            ->field('a.id,a.username,b.*')
            ->order('b.time desc')
            ->paginate(20,false,['query'=>request()->param()]);
        $this->assign('data', $arr);
        //print_r($arr);
        return $this->fetch();
    }
}