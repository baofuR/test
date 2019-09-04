<?php

namespace app\index\controller;
header("Access-Control-Allow-Origin: * ");

//header("Access-Control-Allow-Method:POST,GET");
use think\Controller;
use think\Request;
use think\Db;
use think\Validate;
use think\Session;
use think\Config;
use think\helper\Time;
class Ajax extends Controller
{

    /**
     * 获取时时彩数据
     */
  /*
  public function req_api()
   {        
        //接口一
		/*$url = "http://www.txzxtj.com/ct-data/onlineReportList?jqueryGridPage=1&jqueryGridRows=1&code=tx";
		$arr = $this->curl_get($url);
		$json = json_decode($arr);
        $res = (array)$json->data[0];
		$onlineCount = trim($res['onlineCount']);
		$openTime = date('Y-m-d H:i:00', strtotime(trim($res['openTime'])));*/
		
		//接口二
		//$url = "http://www.off0.com/list";
		//$arr = $this->curl_get($url);
		//$json = json_decode($arr);
        //$res = (array)$json[0];
		//$onlineCount = trim($res['total']);
		//$openTime = date('Y-m-d H:i:00', strtotime(trim($res['time'])));
		
		//接口三
		/*$url = Config::get('web_url') . "txffc.php"; //接口放到pubilc下
		$arr = $this->curl_get($url);
		$json = json_decode($arr);
        $res = (array)$json[0];
		$onlineCount = trim($res['onlinenumber']);
		$openTime = date('Y-m-d H:i:00', strtotime(trim($res['onlinetime'])));*/
		
       // 
		//每日零点
       // $today = strtotime(date("Y-m-d"), time());
      //  //格式转时间戳
     //   $oldtime = $openTime;
       // $catime = strtotime($oldtime);
      //  $record = substr($onlineCount, -4);
//
      //  $regex = "/([a-zA-Z]{1})/";
       // $result = preg_replace($regex, "$1", $onlineCount);
     //   $arr = str_split($result, 1);
        //print_r($arr);
     //   $sum = 0;
     //   foreach ($arr as $key => $v) {
      //      $sum += $v;
       // }
        //echo $sum;
       // $kaij = $sum % 10 . $record;
        //print_r($kaij);
   //     $data = [
         //   'qihao' => ($catime - $today) / 60,
         //   'record' => $kaij,
       //     'kjtime' => $openTime,
      //      'onlinenum' => $onlineCount
       // ];
      //print_r($data);
      //exit;
     //   $f = db('record')->order('id desc')->find();
        //print_r($f['id']);
//        $f['id'] = 10002;
//        $f['kjtime'] = '2019-01-15 17:00:00';
      //  $s = db('record')->where('kjtime', $f['kjtime'])->count();
        //print_r($s);

        //去重复
     //   if ($s >= 2) {
         //   for ($i = $f['id']; $i > $f['id'] - $s + 1; $i--) {
         //       $a = db('record')->where('id', $i)->delete();
         //   }
      //  }

     //  $num2 = 0;
      //  $numhs = substr($kaij, -2, 2);
      //  if ($numhs >=0 && $numhs<=26) {
       //     $num2 = 0;
      //  }else if ($numhs >26 && $numhs <=53) {
     //       $num2 = 3;
    //    }else if ($numhs >53 && $numhs <=76) {
      //      $num2 = 2;
     //   }else if ($numhs >76 && $numhs <=99) {
        //    $num2 = 1;
     //   }
//        $num3 = substr($kaij, -1);
       // echo $num2;
      //  $rand = rand(1, 13) * 10;
//        $num = ($num1 + $num2 + $num3) % 4;
     //   $kjnum = $rand + $num2;
//echo $kjnum;
// exit();
   //     if ($f['kjtime'] !== $openTime) {
      //      $db = db('record')->insert($data);
			
         //   if (preg_match('/(.+)\\1{2}/', $kaij)) {
                // $dat = ['kjnum' => 'wang'];
              //  $res = db('record')->where('qihao', $data['qihao'])->setField('kjnum', 'wang');
            //} else {
          //      //$da = ['kjnum' => $kjnum];
        //        $res = db('record')->where('qihao', $data['qihao'])->setField('kjnum', $kjnum);
      //      }
    //    }
    //}
	public function req_api()
    {
        $url = "http://api.b1api.com/api?p=json&t=txffc&limit=20&token=2CB077CE80C64311";
        //$arr =file_get_contents($url);
        $arr = $this->curl_get($url);
//        dump($arr);
        $res = json_decode($arr, true);
        $da = $res['data'];
        $code = str_replace(',', '', $da[0]['opencode']);
        $record = substr($da[0]['expect'], -4);
        $data = [
            'qihao' => $record,
            'record' => $code,
            'kjtime' => $da[0]['opentime'],
            'onlinenum' => $da[0]['expect'],
            'kjnum' => rand(1, 13) * 10
        ];

        $f = db('record')->order('id desc')->find();
        //print_r($f['id']);
//        $f['id'] = 10002;
//        $f['kjtime'] = '2019-01-15 17:00:00';
        $s = db('record')->where('onlinenum', $f['onlinenum'])->count();
        //print_r($s);

        //去重复
        if ($s >= 2) {
            for ($i = $f['id']; $i > $f['id'] - $s + 1; $i--) {
                $a = db('record')->where('id', $i)->delete();
            }
        }
        if ($f['onlinenum'] !== $da[0]['expect']) {
            $db = db('record')->insert($data);
        }
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

    /**
     * 返回记录
     */
    public function fanrecord()
    {
        $today = strtotime(date("Y-m-d"), time());
        $now = time();
        $time = $now - $today;
        $data = db('record')->order('kjtime desc')->find();
        //拼接期号和年月日
        $strtime = strtotime($data['kjtime']);
        $strtime = date("Ymd", $strtime);
        if ($data['qihao'] < 10) {
            $qishu = $strtime . "000" . $data['qihao'];
        } elseif ($data['qihao'] > 10 && $data['qihao'] < 100) {
            $qishu = $strtime . "00" . $data['qihao'];
        } elseif ($data['qihao'] > 100 && $data['qihao'] < 1000) {
            $qishu = $strtime . "0" . $data['qihao'];
        } else {
            $qishu = $strtime . $data['qihao'];
        }
        //$a = $data['qihao'] % 100;
        $arr = [
            'id' => $data['id'],
            'record' => $data['record'],
            'kjtime' => $data['kjtime'],
            'onlinenumber' => $data['onlinenum'],
            'time' => $time,
            'kjnum' => $data['kjnum'],
            'qishu' => $qishu
        ];
        return json($arr);
    }

    /**
     * 获取3.8用户信息并且返回信息
     */
    public function getuserinfo()
    {
        $id = session("userid");
      //$id = 644;
        $data = db('user_list')->where('id', $id)->find();
      	if(!$data['ip']){
        	$ip = Request::instance()->ip();
          	db('user_list')->where('id',$id)->setField('ip',$ip);
        }
       
      $json = [
            'id' => $data['id'],
            'nickname' => $data['nickname'],
            'headimgurl' => $data['headimgurl'],
            'balance' => $data['balance'],
            'status' => $data['status'],
          'openid' => $data['openid']
        ];
        return json($json);
    }

    public function fanhuijilu()
    {
        //每日零点
        $today = strtotime(date("Y-m-d"), time());
        $data = db('record')->order('id desc')->find();
        $strtime = strtotime($data['kjtime']);
        $time = ($strtime - $today) / 60 % 100;
        //第几轮
        $time1 = floor(($strtime - $today) / 60 / 100) + 1;
        if ($time == 0) {
            $res = [];
        } else {
            $res = db('record')->order('id desc')->field('kjnum')->limit($time)->select();
        }
        $arr = array(
            array(
                $time
            ),
            array(
                $time1
            ),
            array(
                $data['qihao']
            ),
            $res
        );
        //print_r($res);
        return json($arr);
    }

    //返回下注记录
    public function xiazhujilu()
    {
        $id = session('userid');
        $data = db('xiazhujilu')->where('userid', $id)->select();
        return json($data);
    }

    //返回客服二维码
    public function kefu()
    {
        $data = db('config')->find();
        $img = $_SERVER['HTTP_HOST'] . '/uploads/' . $data['image'];
        return json($img);
    }
      //返回客服二维码
    public function qqkefu()
    {
        $data = db('config')->find();
        $img = $_SERVER['HTTP_HOST'] . '/uploads/' . $data['qqimage'];
        return json($img);
    }

    //返回公告
    public function gonggao()
    {
        $data = db('config')->find();
        $text = $data['gonggao'];
//        $weihu = $data['sysweihu'];
//        $arr = array(
//            $text,
//            $weihu
//        );
        return json($text);
    }

    //3.8第三方支付
    public function paysapi()
    {
        $id = session('userid');
        $mch_id = '20589';//这里改成支付ID
        $mch_key = '5EXI87F2PulZA9weDFEaPhNIWhotMDFs'; //这是您的通讯密钥
        $data = array(
            "mch_uid" => $mch_id,//你的支付ID
            "out_trade_no" => time(), //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "pay_type_id" => $_GET['pay_id'],//1微信支付 2支付宝
            "total_fee" => $_GET['total'],//金额
            "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . '/index.php/index/notifyurl/index',//通知地址
            "return_url" => 'http://' . $_SERVER['HTTP_HOST'],//跳转地址
            "mepay_type" => $_GET['mepay'],//
            "param" => $id,
        ); //构造需要传递的参数
        //echo $data['notify_url'];exit();
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空
//        print_r($data);
        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign . $mch_key); //创建订单所需的参数
        $url = "https://www.zhapay.com/pay.html?{$query}"; //支付页面
        header("Location:{$url}"); //跳转到支付页面
        exit();
    }

    //获取用户上传的提现码
    public function getimg(Request $request)
    {
        $data = request()->param();
        $id = session('userid');
//        $kcid = session("kcid");
        $image = $data['base'];

        $imageName = "25220" . date("His", time()) . rand(1111, 9999) . '.png';
        if (strstr($image, ",")) {
            $image = explode(',', $image);
            $image = $image[1];
        }
        $path = "./" . "utixianma";

        if (!is_dir($path)) { //判断目录是否存在 不存在就创建
            mkdir($path, 0777, true);
        }
        $imageSrc = $path . "/" . $imageName;
        $r = file_put_contents($imageSrc, base64_decode($image));
        $imageSrc = json_encode($imageSrc);
        $img = stripslashes($imageSrc);
        $s = str_replace('"', '', $img);
        db('user_list')->where('id', $id)->setField('tixianma', $s);
        db('user_list_kc')->where('id', $id)->setField('tixianma', $s);
    }

    //返回二维码
    public function fanerweima()
    {
        $id = session('userid');
        $data = db('user_list')->where('id', $id)->field('tixianma')->find();
      $data = 'http://' . $_SERVER['HTTP_HOST'] .substr($data['tixianma'],1);
        return json($data);
    }

    //用户提现
    public function txrecord(Request $request)
    {
        $arr = request()->param();
        $id = session('userid');
//        $kcid = session('kcid');
        $jine = number_format($arr['jine'],2,".","");
        //3.8总下注
        $hei = db('xiazhujilu')->where('userid', $id)->sum('hei');
        $hong = db('xiazhujilu')->where('userid', $id)->sum('hong');
        $meihua = db('xiazhujilu')->where('userid', $id)->sum('meihua');
        $fangpian = db('xiazhujilu')->where('userid', $id)->sum('fangpian');
        $wang = db('xiazhujilu')->where('userid', $id)->sum('wang');
        $zongxz = number_format($hei + $hong + $meihua + $fangpian + $wang,2,".","");
        //3.8总充值
        $chongzhi = db('user_list')->where('id', $id)->find();
      	$tixiankc = db('user_list_kc')->where('id', $id)->find();
        $newcz = db('user_chongzhi')->where('userid', $id)->order('dtime desc')->find();
//        print_r($newcz);
        $time = date('Y-m-d H:i:s', $newcz['dtime']);
        $xiazhu1 = db('xiazhujilu')->where('time', 'gt', $time)->where('userid', $id)->sum('hei');
        $xiazhu2 = db('xiazhujilu')->where('time', 'gt', $time)->where('userid', $id)->sum('hong');
        $xiazhu3 = db('xiazhujilu')->where('time', 'gt', $time)->where('userid', $id)->sum('meihua');
        $xiazhu4 = db('xiazhujilu')->where('time', 'gt', $time)->where('userid', $id)->sum('fangpian');
        $xiazhu5 = db('xiazhujilu')->where('time', 'gt', $time)->where('userid', $id)->sum('wang');
        $zongxiazhu = number_format($xiazhu1 + $xiazhu2 + $xiazhu3 + $xiazhu4 + $xiazhu5,2,".","");
//        print_r($xiazhu);
        if ($arr['type'] == 1) {//3.8用户提现
            if ($zongxz >= $chongzhi['chongzhi'] && $jine > 0.0 && $zongxiazhu >= $newcz['jine'] && $chongzhi['balance'] && $jine <= $chongzhi['balance'] && !empty($chongzhi['tixianma'])) {
                $affected = Db::execute("update tp_user_list set balance=balance-$jine,zongtx=zongtx+$jine where id=$id");
				if($affected){
					$data['userid'] = $id;
					$data['jine'] = $jine;
					$data['time'] = time();
					$data['qubie'] = $arr['qubie'];
					db('tixian')->insert($data);
					$a = "提现成功";
				}else{
					$a = "提现失败";
				}
            } else {
                $a = "未达到一倍流水，提现失败";
            }
        }
		
        if ($arr['type'] == 2) { //大吃小用户提现
            if ($jine > 0.0 && $tixiankc['balance'] > 0.0 && $jine <= $tixiankc['balance'] && !empty($tixiankc['tixianma'])) {
              	//db('user_list_kc')->where('id',$id)->setDec('balance',$jine);
                //$balance = db('user_list_kc')->where('id',$id)->find();
                $affected = Db::execute("update tp_user_list_kc set balance=balance-$jine,zongtx=zongtx+$jine where id=$id");
				if($affected){
					$data['userid'] = $id;
					$data['jine'] = $jine;
					$data['time'] = time();
					$data['qubie'] = $arr['qubie'];
					//$data['yue'] = $balance['balance'];
					$data['yue'] = $tixiankc['balance']-$jine;
					db('tixian_kc')->insert($data);
					$a = "提现成功";
				}else{
					$a = "提现失败";
				}
            } else {
                $a = "提现失败";
            }
        }
        return json($a);
    }

    //返回上局记录
    public function shangju()
    {
        //先查最新一条
        $la = db('record')
            ->order('id desc')
            ->find();
        $zx = $la['qihao'] % 100;
        $zuixin = $zx + 100;
        $last = db('record')
            ->field('kjnum,qihao')
            ->order('id desc')
            ->limit($zuixin)
            ->select();
        //print_r($zx);
        if ($zx > 0) {
            for ($i = 0; $i < $zx; $i++) {
                unset($last[$i]);
            }
        }
        $str = array_merge($last);
//        $json = json_encode($last);
//        $data = json_decode($json,true);
        $json = json_encode($str);
        $data = json_decode($json, true);
//        print_r($data);
        return $data;
    }


    /**
     * 北京赛车接口
     */
    public function getapi()
    {
        //判断时间是否在每天的某一区域
        $checkDayStr = date('Y-m-d ', time());
        $timeBegin1 = strtotime($checkDayStr . "09:30" . ":00");
        $timeEnd1 = strtotime($checkDayStr . "13:00" . ":00");
        $curr_time = time();
        $url = "http://wd.apiplus.net/newly.do?token=t59f576c6cf646a44k&code=mlaft&format=json";

        $arr = $this->curlapi($url);
        $arr = json_decode($arr, true);
        //print_r($arr);
        $res = $arr['data'];
        //print_r($res);
        $data = [
            'qihao' => $res['0']['expect'],
            'code' => $res['0']['opencode'],
            'kjtime' => $res['0']['opentime'],
            'time' => $res['0']['opentimestamp']
        ];
        //print_r($data);
        $f = db('record_kc')->order('id desc')->find();
        if ($f['qihao'] !== $res['0']['expect']) {
            $db = db('record_kc')->insert($data);
        }
        //返回北京开船数据
        $fanhu = db('record_kc')->order('time desc')->find();
        $chou = db('config')->field('choushui')->find();
        //print_r($chou);
        $fanhu['choushui'] = $chou['choushui'];
        //print_r($fanhu);
        return json($fanhu);
    }

    public function curlapi($url)
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

    /**
     * 获取北京赛车用户信息并且返回信息
     */
    public function getkcuser()
    {
        $id = session("userid");
        $data = db('user_list_kc')->where('id', $id)->find();
      	if(!$data['ip']){
        	$ip = Request::instance()->ip();
          	db('user_list_kc')->where('id',$id)->setField('ip',$ip);
        }
        //print_r($data);
        $json = [
            'id' => $data['id'],
            'nickname' => $data['nickname'],
            'headimgurl' => $data['headimgurl'],
            'balance' => $data['balance'],
          'openid' => $data['openid']
        ];
        return json($json);
    }

    //返回3.8充值记录
    public function backchongzhi()
    {
        $id = session('userid');
        $data = db('user_chongzhi')->where('userid', $id)->order('dtime desc')->select();
        return json($data);
    }

    //返回3.8提现记录
    public function backtixian()
    {
        $id = session('userid');
        $data = db('tixian')->where('userid', $id)->order('time desc')->select();
        return json($data);
    }

    //北京赛车充值记录
    public function backbjsccz()
    {
        $id = session('userid');
        $data = db('user_chongzhi_kc')->where('userid', $id)->order('dtime desc')->select();
        return json($data);
    }

    //返回北京赛车提现记录
    public function backbjsctx()
    {
        $id = session('userid');
        $data = db('tixian_kc')->where('userid', $id)->order('time desc')->select();
        return json($data);
    }

    //返回北京赛车下注记录
    public function backxzjl()
    {
        $id = session('userid');
        $data = db('xiazhujilu_kc')->where('userid', $id)->select();
        return json($data);
    }

    //3.8房间设置
    public function roomset()
    {
        $data = db('fengding_set')->find();
//        print_r($data);
        return json($data);
    }

    //计算北京赛车佣金
    public function getxiazhu(Request $request)
    {
        $res = request()->param();

        $id = $res['id'];
        $jine = $res['jine'];
        $utid = db('user_list_kc')->where('id', $id)->field('utid')->find();
        $user = db('admin')->where('id', $utid['utid'])->find();
        // $user['utid']2
        if ($user['utid'] !== 0) {
            //一级代理
            $utid1 = db('admin')->where('id', $user['utid'])->find();
            //总佣金
            if ($utid1['utid'] !== 0) {
                //一级代理
                $utid2 = db('admin')->where('id', $utid1['utid'])->find();
                //总佣金200
                $zyj = $jine * $utid2['kcyjdlbili'] / 100;
                //二级佣金100
                $dali2 = $zyj * $utid1['kcyjdlbili'] / 100;
                //三级佣金
                $dali3 = $dali2 * $user['kcyjdlbili'] / 100;
                //二级佣金
                $daili2 = $dali2-$dali3;
                //一级佣金
                $daili1 = $zyj - $dali3 - $daili2;
                db('admin')->where('id', $utid2['id'])->setInc('kcyongjin', $daili1);
                db('admin')->where('id', $utid2['id'])->setInc('mryongjin', $daili1);
                db('admin')->where('id', $utid2['id'])->setInc('zongyj', $daili1);

                db('admin')->where('id', $utid1['id'])->setInc('kcyongjin', $daili2);
                db('admin')->where('id', $utid1['id'])->setInc('mryongjin', $daili2);
                db('admin')->where('id', $utid1['id'])->setInc('zongyj', $daili2);

                db('admin')->where('id', $user['id'])->setInc('kcyongjin', $dali3);
                db('admin')->where('id', $user['id'])->setInc('mryongjin', $dali3);
                db('admin')->where('id', $user['id'])->setInc('zongyj', $dali3);
            } else {
                //总佣金
                $zyj = $jine * $utid1['kcyjdlbili'] / 100;
                //二级佣金
                $dali2 = $zyj * $user['kcyjdlbili'] / 100;
                //一级佣金
                $daili1 = $zyj - $dali2;
                db('admin')->where('id', $utid1['id'])->setInc('kcyongjin', $daili1);
                db('admin')->where('id', $utid1['id'])->setInc('mryongjin', $daili1);
                db('admin')->where('id', $utid1['id'])->setInc('zongyj', $daili1);

                db('admin')->where('id', $user['id'])->setInc('kcyongjin', $dali2);
                db('admin')->where('id', $user['id'])->setInc('mryongjin', $dali2);
                db('admin')->where('id', $user['id'])->setInc('zongyj', $dali2);
            }
        } else {
            $yongjin = $jine * $user['kcyjdlbili'] / 100;
            db('admin')->where('username', $user['username'])->setInc('kcyongjin', $yongjin);
            db('admin')->where('username', $user['username'])->setInc('mryongjin', $yongjin);
            db('admin')->where('username', $user['username'])->setInc('zongyj', $yongjin);
        }
    }

    //北京赛车第三方支付
    public function kcpaysapi()
    {
        $id = session('userid');
        $mch_id = '20589';//这里改成支付ID
        $mch_key = '5EXI87F2PulZA9weDFEaPhNIWhotMDFs'; //这是您的通讯密钥
        $data = array(
            "mch_uid" => $mch_id,//你的支付ID
            "out_trade_no" => time(), //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "pay_type_id" => $_GET['pay_id'],//1微信支付 2支付宝
            "total_fee" => $_GET['total'],//金额
            "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . '/index.php/index/kcnotifyurl/index',//通知地址
            "return_url" => 'http://' . $_SERVER['HTTP_HOST'],//跳转地址
            "mepay_type" => $_GET['mepay'],//
            "param" => $id,
        ); //构造需要传递的参数
        //echo $data['notify_url'];exit();
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空
//        print_r($data);
        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign . $mch_key); //创建订单所需的参数
        $url = "https://www.zhapay.com/pay.html?{$query}"; //支付页面
        header("Location:{$url}"); //跳转到支付页面
        exit();
    }

    //接收注册数据
    public function register(Request $request)
    {
      	$ip = Request::instance()->ip();
      $count = db('user_list')->where('ip',$ip)->count();
      	if($count <= 10) {
                $data = request()->param();
    //        print_r($data);
            $rule = [
                //'字段名'=>'规则1|规则2|...'
                'nickname' => 'require|length:2,100|unique:user_list',
                'pass' => 'require|min:6'
            ];
    //        print_r($rule);
            $message = [
                'nickname.require' => "用户名不能为空",
                'nickname.length' => "用户名长度非法(2-100位)",
                'nickname.unique' => "用户名被占用请重试",
                'pass.require' => "密码不能为空",
                'pass.min' => "密码长度最短6位"
            ];
            $v = new Validate($rule, $message);
            if (!$v->check($data)) {
                $this->error($v->getError());
            }
            $ip = Request::instance()->ip();
            //判断两次密码是否输入相同, 密码通过获取数据添加到数据库
            $users = [
                'nickname' => $data['nickname'],
                'password' => md5($data['pass']),
                'headimgurl' => '/headimg/headimg.jpg',
                'regtime' => time(),
                'ip' => $ip
            ];
            if ($users) {
                Db::table('tp_user_list')->insert($users);
                Db::table('tp_user_list_kc')->insert($users);
    //            $res = db('user_list')->insert($users);
    //            $res1 = db('user_list_kc')->insert($users);
                $a = "注册成功";
            } else {
                $a = "注册失败";
            }
            return json($a);
        } else {
          $b = "一个IP最多注册十个账号";
        	return $b;
        }
        
    }

    //登陆
    public function login(Request $request)
    {
        $data = request()->param();
        $user = db('user_list_kc')
            ->where('nickname', $data['nickname'])
            ->where('password', md5($data['pass']))
            ->find();
        if ($user['status'] == 1){
			echo "禁止进入游戏,请联系客服!";
            exit;
        }else{
            if ($user) {
                $userid = $user['id'];
                session("userid", $userid);
                $a = "登陆成功";
            } else {
                $a = "登陆失败";
            }
            
        }
        return json($a);
    }

    //3.8房间维护
    public function weihu()
    {
        $data = db('config')->field('chuantong,dazhong,chuantong1')->find();
        return json($data);
    }
  
  //大吃小房间维护
      public function dcxweihu()
    {
        $data = db('config')->field('chuantong2,dazhongdcx,dcxvip')->find();
        return json($data);
    }
  	
  	  //大吃小抽水比例
      public function dcxchoushui()
    {
        $data = db('config')->field('choushui')->find();
        return json($data);
    }
	
  	//房间密码
  	public function roompwd(){
     	$data = db('roompwd')->find();
        return json($data);
    }
	//停止下注
	public function stopxiazhu(){
     	$data = db('config')->field('stopxiazhu')->find();
        return json($data);
    }
      //充值添加订单
    public function addchongzhi()
    {
        $id = $_POST['userid'];
        $jine = $_POST['jine'];
        $type = $_POST['type'];
        if ($jine > 0) {
            $data['userid'] = $id;
            $data['jine'] = $jine;
            $data['ddanhao'] = date("YmdHis");
            $data['dtime'] = time();
            $data['ctype'] = $type;
            $res = db('user_chongzhi_kc')->insert($data);
            if ($res) {
                echo json_encode(array('status' => 200));
                exit();
            }
        }
    }

    //每天下注人数
    public function playday()
    {
        $time = Time::today();
        $id = $_POST['userid'];

        $now = time();
        if ($now > $time[0] && $now < $time[1]) {
            $arr = db('day_play')->where('userid', $id)->where('time', 'between', [$time[0], $time[1]])->count();
            if ($arr == 0) {
                $data['userid'] = $id;
                $data['time'] = $now;
                //print_r($data);
                db('day_play')->insert($data);
            }
        }
    }
}