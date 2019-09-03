<?php

namespace app\index\controller;

use think\Controller;

class Kcnotifyurl extends Controller
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
            $f = db('user_chongzhi_kc')->where('ddanhao', $transaction_id)->find();
            if (!$f) {
                $a = db('user_chongzhi_kc')->insert($da);
                $b = db('user_list_kc')->where('id', $param)->setInc('balance', $total_fee);
                $c = db('user_list_kc')->where('id', $param)->setInc('chongzhi', $total_fee);
            }
            exit('success'); //返回成功 不要删除哦
        }
    }
}