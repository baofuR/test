<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use think\Db;

class Kcdaili extends Controller
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

        $users = [
            'username' => $data['username'],
            'password' => md5($data['password']),
            'created' => time(),
            'guanlitype' => $data['guanlitype'],
            'erjidaili' => $data['erjidaili'],
            'utid' => $data['utid'],
            'yjdlbili' => $data['yjdlbili'],
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
        $admin = session("admin");
        $res = db('admin')->where('username', $admin['username'])->find();
        $data = db('admin')
            ->where('utid', $res['id'])
            ->paginate(7);
        $arr = db('admin')
            ->where('utid', $res['id'])
            ->select();
        foreach ($arr as $k => $v) {
            $tixian = db('tixian_kc')->where('userid',$v['id'])->where('status',2)->where('qubie',1)->sum('jine');
            $arr[$k]['tixian'] = $tixian;
        }
        $this->assign('arr', $arr);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //代理下级人员
    public function xiajinum()
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
        //每日下注总额
        $mrxz = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->where('time', 'between', [$start_time, $end_time])
            ->sum('b.xiazhuzong');
        //总下注
        $zxz = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_xiazhujilu_kc b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->sum('b.xiazhuzong');
        //总下属人数
        $num = db('user_list_kc')
            ->where('utid', $data['id'])
            ->count();
        //总充值
        $money = Db::table('tp_user_list_kc')
            ->alias('a')
            ->join('tp_user_chongzhi_kc b', 'a.id = b.userid')
            ->where('a.utid', $data['id'])
            ->sum('jine');
        $res = db('admin')->where('username', $admin['username'])->field('yongjin')->find();
        $arr = array(
            'erweima' => $data['erweima'],
            'yongjin' => $res['yongjin'],
            'num' => $num,
            'chongzhi' => $money,
            'mrxz' => $mrxz,
            'zxz' => $zxz
        );
        //print_r($arr);
        $this->assign('arr', $arr);
        return $this->fetch();
    }

    //提现
    public function tixian()
    {
        $admin = session("admin");
        $data = db('admin')->where('id', $admin['id'])->field('id,yongjin')->find();
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
        if ($jine > 0) {
            $data['userid'] = $id;
            $data['jine'] = $jine;
            $data['time'] = time();
            $data['qubie'] = $arr['qubie'];
            db('tixian_kc')->insert($data);
            Db::execute("update tp_admin set yongjin=yongjin-$jine where id=$id");
            $this->success('操作成功', 'admin/kcdaili/tixian');
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
            ->join('tp_tixian_kc b', 'a.id = b.userid')
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
        $res = db('tixian_kc')->where('id', $id)->setField('status', 2);
    }

}