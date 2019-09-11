<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use think\Db;
class User extends Controller
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

    public function login()
    {
        if (request()->isGet()) {
            return $this->fetch();
        } else if (request()->isPost()) {
            $username = input("post.username/s");
            $password = input("post.password/s");
            $admin = db('admin')
                ->field('id, username,erweima')
                ->where('username', $username)
                ->where('password', md5($password))
                ->find();
            if ($admin) {
                session("admin", $admin);
                if (!$admin['erweima']) {
                    //$url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php?m=Wap&c=wxlogin&a=index&sjid=' . $id;
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php/index/index/index/sjid/' . $admin['id'];
                    $level = 3;
                    $size = 4;
                    vendor('phpqrcode.phpqrcode');//引入插件类
                    $errorCorrectionLevel = intval($level);//容错级别
                    $matrixPointSize = intval($size);//生成图片大小
                    //生成二维码图片
                   // print_r($url);
                    $object = new \QRcode();
                    $imageName = "./" . "erweima/" . "25220" . date("His", time()) . rand(1111, 9999) . '.png';
                    $object->png($url, $imageName, $errorCorrectionLevel, $matrixPointSize, 2);
                    $dst_path = 'http://' . $_SERVER['HTTP_HOST'] . '/headimg/tuiguang.jpg';//背景图片路径
                    $src_path = $imageName;//覆盖图
                    //创建图片的实例
                    $dst = imagecreatefromstring(file_get_contents($dst_path));
                    $src = imagecreatefromstring(file_get_contents($src_path));
                    //获取覆盖图图片的宽高
                    list($src_w, $src_h) = getimagesize($src_path);
                    //将覆盖图复制到目标图片上，最后个参数100是设置透明度（100是不透明），这里实现不透明效果
                    imagecopymerge($dst, $src, 140, 590, 0, 0, $src_w, $src_h, 100);
                    header("Content-type: image/png");
                    $a = "./" . "headimg/" . "3235" . date("His", time()) . rand(1111, 9999) . '.png';
                    imagepng($dst,$a);//根据需要生成相应的图片
                    $ewm = db('admin')->where('id', $admin['id'])->setField('erweima', $a);
                }
                $this->redirect(url('admin/index/index'));

            } else {
                $this->error("登陆失败", url('admin/user/login'));
            }
        }

//        $QR = $imageName;
//        $QR = imagecreatefromstring(file_get_contents($QR));
//        print_r($QR);
    }

    public function adminadd()
    {
        return $this->fetch();
    }

    public function doadminadd(Request $request)
    {
        $data = request()->param();
        $rule = [
            //'字段名'=>'规则1|规则2|...'
            'username' => 'require|length:2,100|unique:admin',
            'password' => 'require|min:6',
            'password2' => 'require|confirm:password'
        ];
        $message = [
            'username.require' => "用户名不能为空",
            'username.length' => "用户名长度非法(2-100位)",
            'username.unique' => "用户名被占用请重试",
            'password.require' => "密码不能为空",
            'password.min' => "密码长度最短6位"
        ];
        $v = new Validate($rule, $message);
        if (!$v->check($data)) {
            $this->error($v->getError());
        }

        //判断两次密码是否输入相同, 密码通过获取数据添加到数据库
        if ($data['password'] != $data['password2']) {
            $this->error("两次密码输入不一致,请重新输入");
        }

        $users = [
            'username' => $data['username'],
            'password' => md5($data['password']),
            'created' => time(),
            'guanlitype' => $data['guanlitype'],
//            'yjdlbili' => $data['yjdlbili'],
            'kcyjdlbili' => $data['kcyjdlbili']
        ];
        if ($users) {
            $res = db('admin')->insert($users);
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
    }


    public function userlist()
    {
        $res = db('admin')->where('guanlitype', 1)->order('id DESC')->paginate(10);
        $this->assign('res', $res);
        return $this->fetch();
    }

    public function logout()
    {
        //将session中的admin清空
        session('admin', null);
        //跳转到登陆界面
        $this->redirect(url('admin/user/login'));
    }

    public function changepwd()
    {
        $id = session('admin');
        $data = db('admin')->find($id['id']);
        $this->assign('data', $data);
        return $this->fetch();
    }
	public function changedlpwd($id)
    {
        $data = db('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }
    public function changebili($id)
    {
        $data = db('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }
    public function dochangebili()
      {
          $data = request()->param();
          $id = $data['id'];
          $res = db('admin')->where('id', $id)->update($data);
          if ($res) {
              $this->success('操作成功');
          }else{
              $this->error('操作失败');
          }
      }
    public function dochangepwd(Request $request)
    {
        $data = request()->param();
        $id = $data['id'];
        $pwd = db('admin')->find($id);
        if ($pwd['password'] == md5($data['password'])) {
            $users = [
                'username' => $data['username'],
                'password' => md5($data['password2']),
            ];
        } else {
            $this->error('原密码错误');
        }
        //判断新密码两次输入手一致 然后执行修改操作到数据库
        if ($data['password1'] != $data['password2']) {
            $this->error('两次输入的密码不一致,请重新输入');
        }

        $rule = [
            // '字段名'=>'规则1|规则2|...'
            'username' => 'require|length:2,100',
            'password2' => 'require|min:6',
        ];

        $message = [
            'username.require' => '用户名不能为空',
            'username.length' => "用户名长度非法(2-100位)",
            'password2.require' => '密码不能为空',
            'password2.min' => '密码最少6位',
        ];
        $v = new Validate($rule, $message);
        if (!$v->check($data)) {
            $this->error($v->getError());
        }

        if ($users) {
            $res = db('admin')->where('id', $id)->update($users);
            $this->success('修改成功');
        } else {
            $this->error('修改失败');
        }
    }

    //删除管理员
    public function admindel($id)
    {
        $res = db('admin')->delete($id);
        if ($res) {
            $this->redirect(url('admin/user/userlist'));
        } else {
            $this->error('删除失败');
        }
    }

    //代理列表
    public function dailinum()
    {
  		//每天开始时间 结束时间
            $start_time = strtotime(date("Y-m-d",time()));
            $start_time1 = date("Y-m-d", time());
            //当天结束之间
            $end_time = $start_time+60*60*24;
            $end_time2 = date("Y-m-d", $end_time);
        $res = db('admin')->where('guanlitype', 2)->order('id desc')->select();
        foreach ($res as $k => $v) {
            $tixian = db('tixian')->where('userid',$v['id'])->where('status',2)->where('qubie',1)->sum('jine');
          $xiaji1 = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_xiazhujilu b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time1, $end_time2])
            ->sum('b.shangfenhou');
            $xiaji2 = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_xiazhujilu b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time1, $end_time2])
            ->sum('b.shangfenqian');

            $xiaji3 = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time, $end_time])
            ->sum('b.zengjia');
            $xiaji4 = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time, $end_time])
            ->sum('b.xiazhuzong');
          	
          	//3.8 4.0余额
            $balance = db('user_list')->where('utid',$v['id'])->sum('balance');
            //大吃小余额
            $dcxbalance = db('user_list_kc')->where('utid',$v['id'])->sum('balance');
            //3.8 4.0充值
            $chongzhi = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_user_chongzhi b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //大吃小充值
            $dcxchongzhi = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_user_chongzhi_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //3.8 4.0 提现
            $sstixian = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_tixian b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
            //大吃小提现
            $dcxtixian = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_tixian_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
          	
          	//3.8 4.0余额
            $res[$k]['balance'] = $balance;
            //大吃小余额
            $res[$k]['dcxbalance'] = $dcxbalance;
            //3.8 4.0充值
            $res[$k]['chongzhi'] = $chongzhi;
            //大吃小充值
            $res[$k]['dcxchongzhi'] = $dcxchongzhi;
            //3.8 4.0提现
            $res[$k]['sstixian'] = $sstixian;
            //大吃小提现
            $res[$k]['dcxtixian'] = $dcxtixian;
          	$bjhuode = ($xiaji1 - $xiaji2);
            $fthuode = ($xiaji3 - $xiaji4);
            $res[$k]['bjhuode'] = $bjhuode;
            $res[$k]['fthuode'] = $fthuode;
            $res[$k]['tixian'] = $tixian;
        }
        $this->assign('res', $res);
     
        return $this->fetch();
    }
      //二级代理列表
    public function erji()
    {
        //每天开始时间 结束时间
            $start_time = strtotime(date("Y-m-d",time()));
            $start_time1 = date("Y-m-d", time());
            //当天结束之间
            $end_time = $start_time+60*60*24;
            $end_time2 = date("Y-m-d", $end_time);
        $res = db('admin')->where('guanlitype', 3)->order('id desc')->select();
        foreach ($res as $k => $v) {
            $tixian = db('tixian')->where('userid',$v['id'])->where('status',2)->where('qubie',1)->sum('jine');
            $xiaji1 = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_xiazhujilu b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between',[$start_time1, $end_time2])
            ->sum('b.shangfenhou');
            $xiaji2 = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_xiazhujilu b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time1, $end_time2])
            ->sum('b.shangfenqian');
      
            $xiaji3 = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time, $end_time])
            ->sum('b.zengjia');
            $xiaji4 = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b','a.id= b.userid')
            ->where('a.utid=' . $v['id'])
            ->where('b.time', 'between', [$start_time, $end_time])
            ->sum('b.xiazhuzong');
            //3.8 4.0余额
            $balance = db('user_list')->where('utid',$v['id'])->sum('balance');
            //大吃小余额
            $dcxbalance = db('user_list_kc')->where('utid',$v['id'])->sum('balance');
            //3.8 4.0充值
            $chongzhi = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_user_chongzhi b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //大吃小充值
            $dcxchongzhi = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_user_chongzhi_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //3.8 4.0 提现
            $sstixian = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_tixian b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
            //大吃小提现
            $dcxtixian = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_tixian_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
            $bjhuode = ($xiaji1 - $xiaji2);
            $fthuode = ($xiaji3 - $xiaji4);
            //3.8 4.0余额
            $res[$k]['balance'] = $balance;
            //大吃小余额
            $res[$k]['dcxbalance'] = $dcxbalance;
            //3.8 4.0充值
            $res[$k]['chongzhi'] = $chongzhi;
            //大吃小充值
            $res[$k]['dcxchongzhi'] = $dcxchongzhi;
            //3.8 4.0提现
            $res[$k]['sstixian'] = $sstixian;
            //大吃小提现
            $res[$k]['dcxtixian'] = $dcxtixian;

             $res[$k]['bjhuode'] = $bjhuode;
            $res[$k]['fthuode'] = $fthuode;
            $res[$k]['tixian'] = $tixian;
        }
        $this->assign('res',$res);
        return $this->fetch();
    }
    //删除代理
    public function dailidel($id)
    {
        $res = db('admin')->delete($id);
        if ($res) {
            $this->redirect(url('admin/user/userlist'));
        } else {
            $this->error('删除失败');
        }
    }

    //减佣金
    public function jianyongjin($id)
    {
        $data = db('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function dojianyongjin($id)
    {
        $yongjin = request()->param('jianyj');
        $data = db('admin')->where('id',$id)->setDec('zongyj',$yongjin);
        if ($data){
            $arr['adminid'] = $id;
            $arr['jine'] = $yongjin;
            $arr['time'] = time();
            db('xia_yongjin')->insert($arr);
            $this->success('操作成功');
        }
    }
  //三级代理列表
    public function sanji()
    {
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d",time()));
        $start_time1 = date("Y-m-d", time());
        //当天结束之间
        $end_time = $start_time+60*60*24;
        $end_time2 = date("Y-m-d", $end_time);
        $res = db('admin')->where('guanlitype', 4)->order('id desc')->select();
        foreach ($res as $k => $v) {
            $tixian = db('tixian')->where('userid',$v['id'])->where('status',2)->where('qubie',1)->sum('jine');
            $xiaji1 = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_xiazhujilu b','a.id= b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.time', 'between',[$start_time1, $end_time2])
                ->sum('b.shangfenhou');
            $xiaji2 = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_xiazhujilu b','a.id= b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.time', 'between', [$start_time1, $end_time2])
                ->sum('b.shangfenqian');

            $xiaji3 = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_xiazhujilu_kc b','a.id= b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.time', 'between', [$start_time, $end_time])
                ->sum('b.zengjia');
            $xiaji4 = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_xiazhujilu_kc b','a.id= b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.time', 'between', [$start_time, $end_time])
                ->sum('b.xiazhuzong');
            //3.8 4.0余额
            $balance = db('user_list')->where('utid',$v['id'])->sum('balance');
            //大吃小余额
            $dcxbalance = db('user_list_kc')->where('utid',$v['id'])->sum('balance');
            //3.8 4.0充值
            $chongzhi = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_user_chongzhi b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //大吃小充值
            $dcxchongzhi = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_user_chongzhi_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->sum('jine');
            //3.8 4.0 提现
            $sstixian = Db::table('tp_user_list')
                ->alias('a')
                ->join('tp_tixian b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
            //大吃小提现
            $dcxtixian = Db::table('tp_user_list_kc')
                ->alias('a')
                ->join('tp_tixian_kc b','a.id = b.userid')
                ->where('a.utid=' . $v['id'])
                ->where('b.qubie','EQ',2)
                ->where('b.status',2)
                ->sum('jine');
            $bjhuode = ($xiaji1 - $xiaji2);
            $fthuode = ($xiaji3 - $xiaji4);
            //3.8 4.0余额
            $res[$k]['balance'] = $balance;
            //大吃小余额
            $res[$k]['dcxbalance'] = $dcxbalance;
            //3.8 4.0充值
            $res[$k]['chongzhi'] = $chongzhi;
            //大吃小充值
            $res[$k]['dcxchongzhi'] = $dcxchongzhi;
            //3.8 4.0提现
            $res[$k]['sstixian'] = $sstixian;
            //大吃小提现
            $res[$k]['dcxtixian'] = $dcxtixian;

            $res[$k]['bjhuode'] = $bjhuode;
            $res[$k]['fthuode'] = $fthuode;
            $res[$k]['tixian'] = $tixian;
        }
        $this->assign('res',$res);
        return $this->fetch();
    }
  	    //将一级代理变为二级代理
    public function jianlevel($id)
    {
        $data = db('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function dojianlevel($id)
    {
        $utid = request()->param('utid');
//        $sdbbili = request()->param('yjdlbili');
//        $kcbili = request()->param('kcyjdlbili');
      
        $data['utid'] = $utid;
//        $data['yjdlbili'] = $sdbbili;
//        $data['kcyjdlbili'] = $kcbili;
        $res = db('admin')->where('id', $id)->update($data);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
  
        //将一级代理变为二级代理
      public function jiandengji($id)
      {
          $data = db('admin')->find($id);
          $this->assign('data', $data);
          return $this->fetch();
      }
      public function dojiandengji($id)
      {
          $utid = request()->param('utid');
          $data['utid'] = $utid;
          $data['guanlitype'] = 3;
          $res = db('admin')->where('id', $id)->update($data);
          if ($res) {
              $this->success('操作成功');
          } else {
              $this->error('操作失败');
          }
      }
}