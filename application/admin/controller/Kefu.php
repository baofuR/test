<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;

class Kefu extends Controller
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

    public function index()
    {
        $admin = session("admin");
        $data = db('admin')->where('username', $admin['username'])->find();
		$config = db('config')->find();
        $this->assign('data', $data);
        $this->assign('config', $config);
        return $this->fetch();
    }

    public function upload(Request $request)
    {
        $data = request()->param();
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if ($info) {
                //保存输出路径
                $data['image'] = $info->getSaveName();
                //$this->success('上传成功!','index');
            } else {
                //报错提示
                $this->error($file->getError());
            }
        }
        $m = db('config')->find();
        $model = db('config')->where('id', $m['id'])->setField('image', $data['image']);
        if ($model) {
            $this->success('添加成功', url('index'));
        } else {
            $this->error("添加失败");
        }
    }
  	public function qqupload(Request $request)
    {
        $data = request()->param();
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if ($info) {
                //保存输出路径
                $data['image'] = $info->getSaveName();
                //$this->success('上传成功!','index');
            } else {
                //报错提示
                $this->error($file->getError());
            }
        }
        $model = db('config')->where('id=1')->setField('qqimage', $data['image']);
        if ($model) {
            $this->success('添加成功', url('index'));
        } else {
            $this->error("添加失败");
        }
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
		imagecopymerge($dst, $src, 140, 590, 0, 0, $src_w, $src_h, 100);
		header("Content-type: image/png");
		$a = "./" . "headimg/" . "3235" . date("His", time()) . rand(1111, 9999) . '.png';
		imagepng($dst,$a);//根据需要生成相应的图片
		$ewm = db('admin')->where('id', $data['id'])->setField('erweima', $a);
		if ($ewm) {
            $this->success('生成成功', url('index'));
        } else {
            $this->error("生成失败");
        }
	}
}