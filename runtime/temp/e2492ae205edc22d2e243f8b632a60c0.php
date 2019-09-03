<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\shanchuang\game\public/../application/admin\view\fengding\showfd.html";i:1565163876;}*/ ?>
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
    <title>房间下注封顶</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" action="<?php echo url('admin/fengding/saveset'); ?>">
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大众房：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="dazhong" value="<?php echo $data['dazhong']; ?>">
            </div>
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大王：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="dazhongwang" value="<?php echo $data['dazhongwang']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>传统房：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="chuantongfang" value="<?php echo $data['chuantongfang']; ?>">
            </div>
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大王：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="chuantongfangw" value="<?php echo $data['chuantongfangw']; ?>">
            </div>
            <span></span>
        </div>
        <br><br>
        <!--<div class="row cl">
            <font size="2" color="red">大众房个人下注上限：</font>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>黑桃：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="hei" value="<?php echo $data['hei']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>红心：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="hong" value="<?php echo $data['hong']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>梅花：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="hua" value="<?php echo $data['hua']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>方块：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="fang" value="<?php echo $data['fang']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大王：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="wang" value="<?php echo $data['wang']; ?>">
            </div>
            <span></span>
        </div>
        <br><br>
        <div class="row cl">
            <font size="2" color="red">传统房个人下注上限：</font>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>黑桃：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="ctfanghei" value="<?php echo $data['ctfanghei']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>红心：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="ctfanghong" value="<?php echo $data['ctfanghong']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>梅花：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="ctfanghua" value="<?php echo $data['ctfanghua']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>方块：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="ctfangfang" value="<?php echo $data['ctfangfang']; ?>">
            </div>
            <span></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-2 col-sm-1"><span class="c-red">*</span>大王：</label>
            <div class="formControls col-xs-2">
                <input type="text" class="input-text" placeholder=""
                       name="ctfangwang" value="<?php echo $data['ctfangwang']; ?>">
            </div>
            <span></span>
        </div>-->
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-1">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
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