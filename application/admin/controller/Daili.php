<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Request;
use think\Validate;
use think\Config;

class Daili extends Controller
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

    //添加二级代理
    public function adminadd()
    {
        $admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
        $this->assign('data', $data);
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
		$admin = session("admin");
        $user = db('admin')->where('username', $admin['username'])->find();
		//if ($data['yjdlbili'] > $user['yjdlbili']) {
		    //$this->error("3.8二级代理比例不能大于一级比例");
		//}
		//if ($data['kcyjdlbili'] > $user['kcyjdlbili']) {
		   // $this->error("北京赛车二级代理比例不能大于一级比例");
		//}
        $users = [
            'username' => $data['username'],
            'password' => md5($data['password']),
            'created' => time(),
            'guanlitype' => $data['guanlitype'],
            'kcyjdlbili' => $data['kcyjdlbili'],
            'utid' => $data['utid'],
//            'yjdlbili' => $data['yjdlbili'],
        ];
        if ($users) {
            $res = db('admin')->insert($users);
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
    }

    //二级代理个数
    public function erjinum()
    {
//        $res = $_POST;
//        $where = [];
//        if (!empty($res) && isset($res)) {
//            $where = $res;
//        }
      //每天开始时间 结束时间
            $start_time = strtotime(date("Y-m-d",time()));
            $start_time1 = date("Y-m-d", time());
            //当天结束之间
            $end_time = $start_time+60*60*24;
            $end_time2 = date("Y-m-d", $end_time);
        $admin = session("admin");
        $res = db('admin')->where('username', $admin['username'])->find();

        $arr = db('admin')
            ->where('utid', $res['id'])
            ->select();
        foreach ($arr as $k => $v) {
            $tixian = db('tixian')->where('userid', $v['id'])->where('status', 2)->where('qubie', 1)->sum('jine');
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
            $bjhuode = ($xiaji1 - $xiaji2);
            $fthuode = ($xiaji3 - $xiaji4);
            $arr[$k]['bjhuode'] = $bjhuode;
            $arr[$k]['fthuode'] = $fthuode;
            $arr[$k]['tixian'] = $tixian;
        }
 
        $this->assign('arr', $arr);
        return $this->fetch();
    }
  	public function changedlpwd($id)
    {
        $data = db('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
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

    //代理3.8下级人员
    public function xiajinum()
    {
        $res = $_POST;
        $where = [];
        if (!empty($res) && isset($res)) {
            $where = $res;
        }
        $admin = session("admin");
        $res = db('admin')->where('username', $admin['username'])->find();
        $data = db('user_list')
            ->where('utid', $res['id'])
            ->where($where)
            ->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

//代理北京赛车下级人员
    public function kcxiajinum()
    {
        $res = $_POST;
        $where = [];
        if (!empty($res) && isset($res)) {
            $where = $res;
        }
        $admin = session("admin");
        $res = db('admin')->where('username', $admin['username'])->find();
        $data = db('user_list_kc')
            ->where('utid', $res['id'])
            ->where($where)
            ->paginate(7);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function xiangguan()
    {
        //每天开始时间 结束时间
        $start_time = strtotime(date("Y-m-d", time()));
        //当天结束之间
        $end_time = $start_time + 60 * 60 * 24;
        //二维码图片
        $admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
        //每日充值总额
        $c = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_user_chongzhi b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->where('dtime', 'between', [$start_time, $end_time])
            ->sum('jine');
        $d = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_user_chongzhi_kc b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->where('dtime', 'between', [$start_time, $end_time])
            ->sum('jine');
        $mrcz = $c + $d;
        //总下属人数
        $num = db('user_list')
            ->where('utid', $data['id'])
            ->count();
        //总充值
        $a = Db::table('tp_user_list')
            ->alias('a')
            ->join('tp_user_chongzhi b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->sum('jine');
        $b = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_user_chongzhi_kc b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->sum('jine');
        $money = $a + $b;
        $res = db('admin')->where('username', $admin['username'])->field('yongjin,kcyongjin')->find();
        $arr = array(
            'erweima' => $data['erweima'],
            'yongjin' => $res['yongjin'],
            'kcyongjin' => $res['kcyongjin'],
            'num' => $num,
            'chongzhi' => $money,
            'mrcz' => $mrcz,
            'yitixian' => $data['yitixian'],
            'zongyj' => $data['zongyj']
        );
        //print_r($arr);
        $this->assign('arr', $arr);
        return $this->fetch();
    }
	
	public function ewm()
    {
		$admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
		//$url = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php?m=Wap&c=wxlogin&a=index&sjid=' . $id;
		$url = Config::get('web_url') . 'index.php/index/index/index/sjid/' . $data['id'];
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
		imagecopymerge($dst, $src, 412, 300, 0, 0, $src_w, $src_h, 100);
		header("Content-type: image/png");
		$a = "./" . "headimg/" . "3235" . date("His", time()) . rand(1111, 9999) . '.png';
		imagepng($dst,$a);//根据需要生成相应的图片
		$ewm = db('admin')->where('id', $data['id'])->setField('erweima', $a);
		if ($ewm) {
            $this->success('生成成功', url('xiangguan'));
        } else {
            $this->error("生成失败");
        }
	}

    //提现
    public function tixian()
    {
        $admin = session("admin");
//        $d = db('admin')->where('id', $admin['id'])->field('id,yongjin,kcyongjin')->find();
//        $zong = $d['yongjin']+$d['kcyongjin'];
        $data = db('admin')->where('id', $admin['id'])->find();
        $this->assign('data', $data);
        //print_r($data);
        return $this->fetch();
    }

    public function tixiansq(Request $request)
    {
        $res = request()->param();
        $arr = [];
        if (!empty($res) && isset($res)) {
            $arr = $res;
        }
        $id = $arr['userid'];
        $jine = $arr['jine'];
      $user = db('admin')->where('id',$id)->find();
      if(!empty($user['tixianma'])){
      	if ($jine > 0) {
            $data['userid'] = $id;
            $data['jine'] = $jine;
            $data['time'] = time();
            $data['qubie'] = $arr['qubie'];
            db('tixian')->insert($data);
            Db::execute("update tp_admin set zongyj=zongyj-$jine where id=$id");
            Db::execute("update tp_admin set yitixian=yitixian+$jine where id=$id");
          Db::execute("update tp_admin set yongjin=0 where id=$id");
          Db::execute("update tp_admin set kcyongjin=0 where id=$id");
            $this->success('操作成功', 'admin/daili/tixian');
        }else{
        $this->error('佣金为0,请勿重复提现');
        }
      }else{
      	$this->error('请上传收款码在进行提现','admin/daili/showtxcode');
      }
        

    }

    //代理上传佣金提现码
    public function showtxcode()
    {
        $admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function upload(Request $request)
    {
        $data = request()->param();
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public/dltixianma');
            if ($info) {
                //保存输出路径
                $data['image'] = $info->getSaveName();
                //$this->success('上传成功!','index');
                //print_r($data['image']);
            } else {
                //报错提示
                $this->error($file->getError());
            }
        }
        $admin = session("admin");
        $model = db('admin')->where('id', $admin['id'])->setField('tixianma', $data['image']);
        if ($model) {
            $this->success('添加成功', url('showtxcode'));
        } else {
            $this->error("添加失败");
        }
    }

    //二级代理提现记录
    public function erjitixian()
    {
        $admin = session("admin");
        $data = Db::table('tp_admin')
            ->alias('a')
            ->join('tp_tixian b', 'a.id = b.userid')
            ->where('a.utid', $admin['id'])
            ->field('a.id,a.username,a.tixianma,b.*')
            ->order('time desc')
            ->paginate(7);
        //print_r($data);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //确认提现
    public function querentx()
    {
        $id = $_GET['id'];
        $res = db('tixian')->where('id', $id)->setField('status', 2);
    }

    //被减佣金记录
    public function jyjrecord()
    {
        $admin = session("admin");
        $data = Db::table('tp_admin')
            ->alias('a')
            ->join('tp_xia_yongjin b', 'a.id = b.adminid')
            ->where('b.adminid', $admin['id'])
            ->field('a.id,a.username,b.*')
            ->order('b.time desc')
            ->paginate(20);
        $this->assign('data',$data);
        return $this->fetch();
    }
      //下级人员下注信息
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
}