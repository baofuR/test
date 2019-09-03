<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\shanchuang\game\public/../application/admin\view\daili\showtxcode.html";i:1557837482;}*/ ?>
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
<form action="<?php echo url('admin/daili/upload'); ?>" enctype="multipart/form-data" method="post">
    <input type="file" name="image" /> <br>
    <input type="submit" value="上传" />
</form>

<div class="row cl">
    <div class="formControls col-sm-9">
        <lable>代理佣金提现码：</lable><img src="/dltixianma/<?php echo $data['tixianma']; ?>" width="300" height="500">
    </div>
</div>
</body>
</html>