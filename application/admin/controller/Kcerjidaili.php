<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Kcerjidaili extends Controller
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

    //佣金提现
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
            $this->success('操作成功', 'admin/kcerjidaili/tixian');
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
}