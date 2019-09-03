<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\shanchuang\game\public/../application/admin\view\ptaiconfig\save.html";i:1558962026;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/static/jquery-ui/jquery-ui.css">
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>系统配置</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" action="<?php echo url('admin/ptaiconfig/saveconfig'); ?>">
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>上传公告：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text"  placeholder="" id="choushui"
                       name="gonggao" value="<?php echo $data['gonggao']; ?>" style="height:111px">
            </div>
            <span></span>
        </div>
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>3.8房间密码：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="password"-->
                       <!--name="password" value="<?php echo $data['password']; ?>">-->
            <!--</div>-->
            <!--<span></span>-->
        <!--</div>-->
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>3.8普通房：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="ptroom"-->
                       <!--name="ptroom" value="<?php echo $data['ptroom']; ?>">-->
            <!--</div>-->
            <!--<span>限制进入分数</span>-->
        <!--</div>-->
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>3.8VIP房间：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="viproom"-->
                       <!--name="viproom" value="<?php echo $data['viproom']; ?>">-->
            <!--</div>-->
            <!--<span>限制进入分数</span>-->
        <!--</div>-->
        <div class="row cl">
        <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大吃小平台抽水：</label>
        <div class="formControls col-xs-2">
        <input type="text" class="input-text"  placeholder="" id="choushui"
        name="choushui" value="<?php echo $data['choushui']; ?>">
        </div>
        <span>%</span>
        </div>
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大吃小房间密码：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="kcpassword"-->
                       <!--name="kcpassword" value="<?php echo $data['kcpassword']; ?>">-->
            <!--</div>-->
            <!--<span></span>-->
        <!--</div>-->
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大吃小普通房：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="kcptroom"-->
                       <!--name="kcptroom" value="<?php echo $data['kcptroom']; ?>">-->
            <!--</div>-->
            <!--<span>限制进入分数</span>-->
        <!--</div>-->
        <!--<div class="row cl">-->
            <!--<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大吃小VIP房：</label>-->
            <!--<div class="formControls col-xs-2">-->
                <!--<input type="text" class="input-text"  placeholder="" id="kcviproom"-->
                       <!--name="kcviproom" value="<?php echo $data['kcviproom']; ?>">-->
            <!--</div>-->
            <!--<span>限制进入分数</span>-->
        <!--</div>-->
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-1">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
	</br>
	<hr>
	</br>
	  <div>
		<div class="row cl">
			<label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>控制下注：</label>
			<div class="formControls col-xs-2">
				<?php switch($data['stopxiazhu']): case "0": ?><a title="禁止" href="<?php echo url('admin/ptaiconfig/stop',['v'=>1]); ?>" onclick="return confirm('是否确认禁止下注')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"><button class="btn btn-primary radius">禁止</button></i></ a><i><br>点击禁止，关闭下注</i><?php break; case "1": ?><a title="启动" href="<?php echo url('admin/ptaiconfig/stop',['v'=>0]); ?>" onclick="return confirm('是否确认启动下注')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"><button class="btn btn-primary radius">启动</button></i></ a><i><br>点击启动，开启下注</i><?php break; endswitch; ?>
			</div>
		</div>
	  </div>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function () {
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>