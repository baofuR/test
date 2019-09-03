<?php

namespace app\index\controller;

use think\Controller;

class Notifyurl extends Controller
{
    public function index()
    {
        //file_put_contents( dirname( __FILE__ ).'/hx_post.txt', var_export($_REQUEST, true), FILE_APPEND );
        ksort($_POST); //排序post参数
        reset($_POST); //内部指针指向数组中的第一个元素
//        print_r($_POST);
        $mch_key = "5EXI87F2PulZA9weDFEaPhNIWhotMDFs"; //这是您的密钥
        $sign = '';//初始化
        foreach ($_POST AS $key => $val) { //遍历POST参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        if (!$_POST['transaction_id'] || md5($sign . $mch_key) != $_POST['sign'] || $_POST['status'] != 1) { //不合法的数据
            exit('fail');  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $out_trade_no = $_POST['out_trade_no']; //需要充值的ID 或订单号 或用户名
            $mepay_total = (float)$_POST['mepay_total']; //提交金额
            $total_fee = (float)$_POST['total_fee']; //用户实际付款
            $param = $_POST['param']; //自定义参数
            $transaction_id = $_POST['transaction_id']; //流水号
            ////////////////这里写业务逻辑/////////////////
            $da['ddanhao'] = $transaction_id;  //单号用当前时间戳加上一个随机数
            $da['userid'] = $param;
            $da['jine'] = $total_fee;
            $da['dtime'] = time();
            $da['ctype'] = $_POST['pay_type'];
//            print_r($da);
            $f = db('user_chongzhi')->where('ddanhao', $transaction_id)->find();
            $utid = db('user_list')->where('id', $param)->field('utid')->find();
            $user = db('admin')->where('id', $utid['utid'])->find();
            if (!$f) {
                $a = db('user_chongzhi')->insert($da);
                if ($user['utid'] !== 0) {
                    //一级代理
                    $utid1 = db('admin')->where('id', $user['utid'])->find();
                    //二级代理
                    //$utid2 = db('admin')->where('utid', $utid1['id'])->find();
                    //总佣金
                    $zyj =$total_fee * $utid1['yjdlbili'] / 100;
                    //二级佣金
                    $dali2 = $zyj * $user['yjdlbili'] / 100;
                    //一级佣金
                    $daili1 = $zyj - $dali2;
                    db('admin')->where('id', $utid1['id'])->setInc('yongjin', $daili1);
                    db('admin')->where('id', $utid1['id'])->setInc('zongyj', $daili1);
                    db('admin')->where('id', $user['id'])->setInc('yongjin', $dali2);
                    db('admin')->where('id', $user['id'])->setInc('zongyj', $dali2);
                }else {
                    $yongjin = $total_fee * $user['yjdlbili'] / 100;
                    db('admin')->where('username', $user['username'])->setInc('yongjin', $yongjin);
                    db('admin')->where('username', $user['username'])->setInc('zongyj', $yongjin);
                }
                $b = db('user_list')->where('id', $param)->setInc('balance', $total_fee);
                $c = db('user_list')->where('id', $param)->setInc('chongzhi', $total_fee);
            }
            exit('success'); //返回成功 不要删除哦
        }
    }
}