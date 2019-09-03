<?php

namespace app\admin\controller;

use think\Controller;
use think\helper\Time;
class Shuju extends Controller
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

    public function showshuju()
    {
        $cc = db('config')->find();
        // //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        // //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
      	$month = Time::month();
        $lastmonth = Time::lastMonth();
        $count = db('day_play')->where('time', 'between', [$start_time, $end_time])->count();
        //每日充值
        $mrsyschongzhi1 = db('user_chongzhi')->where('dtime', 'between', [$start_time, $end_time])->sum('jine');
        $mrsyschongzhi2 = db('user_chongzhi_kc')->where('dtime', 'between', [$start_time, $end_time])->sum('jine');
        $zmrsyschongzhi = $mrsyschongzhi1 + $mrsyschongzhi2;
        //每日提现金额
        //3.8 4.0
        $mrytx1 = db('tixian')->where('time', 'between', [$start_time, $end_time])->where('status', 2)->sum('jine');
        //大吃小
        $mrytx2 = db('tixian_kc')->where('time', 'between', [$start_time, $end_time])->where('status', 2)->sum('jine');
        $zmrytx = $mrytx1 + $mrytx2;
        //后台手动下分总额
        $adminxiafen = db('admin_xiafen')->sum('jine');
        //后台下代理佣金总和
        $adminxiayj = db('xia_yongjin')->sum('jine');
        //大吃小抽水
        $choushui = db('xiazhujilu_kc')
            ->sum('xiazhuzong');
		
        $dcxchoushui = $choushui * $cc['choushui'] / 100;
        //大吃小本月抽水
        $csnowmonth = db('xiazhujilu_kc')
            ->where('time', 'between', [$month[0], $month[1]])
            ->sum('xiazhuzong');
        $csnowm = $csnowmonth * $cc['choushui'] / 100;

        //大吃小上月抽水
        $cslastmonth = db('xiazhujilu_kc')
            ->where('time', 'between', [$lastmonth[0], $lastmonth[1]])
            ->sum('xiazhuzong');
        $cslast = $cslastmonth * $cc['choushui'] / 100;
        //每日佣金
        $mryongjin = db('admin')->sum('mryongjin');
        //佣金
        //$yongjin = db('admin')->where('guanlitype', 2)->sum('zongyj');
        //3.8 4.0余额
        $balance1 = db('user_list')->sum('balance');
        //大吃小余额
        $balance2 = db('user_list_kc')->sum('balance');
        //3.8 4.0总充值
        $chongzhi = db('user_chongzhi')->sum('jine');
        //大吃小充值
        $dcxchongzhi = db('user_chongzhi_kc')->sum('jine');
        //3.8 4.0提现
        $mrtx1 = db('tixian')->where('qubie', 2)->where('status', 2)->sum('jine');
        //大吃小提现
        $mrtx2 = db('tixian_kc')->where('qubie', 2)->where('status', 2)->sum('jine');
        //3.8 4.0一级代理佣金
        $yongjin = db('admin')->sum('yongjin');
        //大吃小一级代理佣金
        $dcxyongjin = db('admin')->sum('kcyongjin');
        //代理提现
        $dltixian = db('tixian')->where('qubie', 1)->where('status', 2)->sum('jine');
        //微信总充值
        $wxchongzhi1 = db('user_chongzhi')->where('ctype', 1)->sum('jine');
        $wxchongzhi2 = db('user_chongzhi_kc')->where('ctype', 1)->sum('jine');
        $wxchongzhi = $wxchongzhi1 + $wxchongzhi2;
        //支付宝总充值
        $zfbchongzhi1 = db('user_chongzhi')->where('ctype', 2)->sum('jine');
        $zfbchongzhi2 = db('user_chongzhi_kc')->where('ctype', 2)->sum('jine');
        $zfbchongzhi = $zfbchongzhi1 + $zfbchongzhi2;
        //后台手动充值
        $syschongzhi1 = db('user_chongzhi')->where('ctype', 'admin')->sum('jine');
        $syschongzhi2 = db('user_chongzhi_kc')->where('ctype', 'admin')->sum('jine');
        $syschongzhi = $syschongzhi1 + $syschongzhi2;
        //3.8 4.0盈亏
        $tixian = ($mrtx1) * 10;
        $win = $chongzhi - $tixian - $balance1;
        $data = array(
            'dcxchongzhi' => $dcxchongzhi,
            'chongzhi' => $chongzhi,
            'balance1' => $balance1,
            'mrtx1' => $mrtx1,
            'mrtx2' => $mrtx2,
            'dcxchoushui' => $dcxchoushui,
            'balance2' => $balance2,
            'yongjin' => $yongjin,
            'dcxyongjin' => $dcxyongjin,
            'dltixian' => $dltixian,
            'wxchongzhi' => $wxchongzhi,
            'zfbchongzhi' => $zfbchongzhi,
            'syschongzhi' => $syschongzhi,
            'win' => $win,
            'zmrsyschongzhi' => $zmrsyschongzhi,
            'zmrytx' => $zmrytx,
            'mryongjin' => $mryongjin,
            'adminxiafen' => $adminxiafen,
            'adminxiayj' => $adminxiayj,
          	'csnowm' => $csnowm,
            'cslast' => $cslast,
            'count' => $count
        );
        $this->assign('data', $data);
        return $this->fetch();
    }
}