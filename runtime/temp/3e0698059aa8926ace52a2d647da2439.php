<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\shanchuang\game\public/../application/admin\view\kefu\index.html";i:1565747760;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上传客服二维码</title>
</head>
<body>
<div class="row cl">
    <form action="<?php echo url('admin/kefu/upload'); ?>" enctype="multipart/form-data" method="post">
      <lable>传微信码</lable><input type="file" name="image"/> <input type="submit" value="上传"/>
    </form>
</div>
<div class="row cl">
    <form action="<?php echo url('admin/kefu/qqupload'); ?>" enctype="multipart/form-data" method="post">
        <lable>传QQ码</lable><input type="file" name="image" />
        <input type="submit" value="上传" />
    </form>
</div>
<div class="row cl">
	<h3>客服二维码</h3>
    <div class="formControls col-sm-9">
        <img  src="http://<?php echo $_SERVER['SERVER_NAME'];?>/uploads/<?php echo $config['image']; ?>" width="200">
      <img  src="http://<?php echo $_SERVER['SERVER_NAME'];?>/uploads/<?php echo $config['qqimage']; ?>" width="200">
    </div>
</div>
<div class="row cl">
	<h3>推广二维码 【<a href="<?php echo url('admin/kefu/ewm'); ?>">重新生成二级码</a>】</h3>
    <div class="formControls col-sm-9">
        <img src="http://<?php echo $_SERVER['SERVER_NAME'];?><?php echo $data['erweima']; ?>" width="500">
    </div>
</div>
</body>
</html>