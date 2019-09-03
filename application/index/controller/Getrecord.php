<?php

namespace app\index\controller;
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method:POST,GET");
use think\Controller;

class Getrecord extends Controller
{
    public function req_api()
    {

        $url = "http://77tj.org/api/tencent/onlineim";

        $arr = $this->curl_get($url);

        $res = json_decode($arr, true);
        print_r($res);die();
//        echo "AAAAAAAAAAAAAAA";
        //每日零点
        $today = strtotime(date("Y-m-d"), time());

        //格式转时间戳
        $oldtime = $res['0']['onlinetime'];
        $catime = strtotime($oldtime);
        $record = substr($res['1']['onlinenumber'], -4);
        $data = [
            'qihao' => $catime - $today / 60,
            'record' => $record,
            'kjtime' => $res['0']['onlinetime'],
            'onlinenum' => $res['1']['onlinenumber']
        ];
//        $db = db('record')->insert($data);
    }

    public function curl_get($url)
    {

        $info = curl_init();
        curl_setopt($info, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($info, CURLOPT_HEADER, 0);
        curl_setopt($info, CURLOPT_NOBODY, 0);
        curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info, CURLOPT_URL, $url);
        $output = curl_exec($info);
        curl_close($info);
        return $output;
    }
}