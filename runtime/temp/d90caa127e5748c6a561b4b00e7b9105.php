<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\shanchuang\game\public/../application/admin\view\index\welcome.html";i:1565776470;}*/ ?>
﻿<!DOCTYPE HTML>
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
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台首页</title>
</head>
<body>
<div class="page-container">
    <p class="f-20 text-success">后台统计</p>
	<hr>
	<br>
	<p class="f-16">未提现订单总数：<?php echo $wtx; ?></p>
	<p>代理未提现订单：<?php echo $wtx1; ?></p>
	<p>大吃小未提现订单：<?php echo $wtx2; ?></p>
  <audio src="http://<?php echo $_SERVER['HTTP_HOST'];?>/musics/userchongzhi.mp3" id="play"></audio>
<audio src="http://<?php echo $_SERVER['HTTP_HOST'];?>/musics/dltixian.mp3" id="playd"></audio>
<audio src="http://<?php echo $_SERVER['HTTP_HOST'];?>/musics/usertixian.mp3" id="playu"></audio>
    <script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
    <script>
        setInterval(function(){
			window.location.reload();
		},30000);
		if(<?php echo $wtx; ?> > 0){
			document.write('<audio autoplay="autoplay"><source src="/static/admin/task.mp3" type="audio/mpeg"></audio>');
			window.parent.modalalertdemo();
		}
        //setInterval('modalalertdemo()',4000);
        function modalalertdemo(){
        	$.Huimodalalert('我是消息框，2秒后我自动滚蛋！',2000);
		}
      setInterval("order()",5000);//每5秒刷新查询一次
    var a='';
    function order() {
        $.ajax({
            type: "POST",
            data: a,
            url: "<?php echo url('admin/record/newczrecord'); ?>",//后台方法
            timeout: 60000,
            cache: false,
            async: false,
            dataType: "json",
            success: function(data) {
                if(data.status == 1){
                    var audio = document.getElementById( "play" ); //浏览器支持 audio
                    audio.play(); //播放提示音

                    setTimeout(function(){
                        window.location.reload();
                    }, 5000);
                }
            }
        });

    }

    setInterval("orderdl()", 5000);//每59秒刷新查询一次
    var b = '';
    function orderdl() {
        $.ajax({
            type: "POST",
            data: b,
            url: "<?php echo url('admin/record/newdltx'); ?>",//后台方法
            timeout: 60000,
            cache: false,
            async: false,
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    var audio = document.getElementById("playd"); //浏览器支持 audio
                    audio.play(); //播放提示音

                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                }
            }
        });

    }
    setInterval("orderu()", 5000);//每59秒刷新查询一次
    var c = '';
    function orderu() {
        $.ajax({
            type: "POST",
            data: c,
            url: "<?php echo url('admin/record/newtxrecord'); ?>",//后台方法
            timeout: 60000,
            cache: false,
            async: false,
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    var audio = document.getElementById("playu"); //浏览器支持 audio
                    audio.play(); //播放提示音
                    setTimeout(function () {
                        window.location.reload();
                    }, 4000);
                }
            }
        });
    }
    </script>

    <!--/此乃百度统计代码，请自行删除-->
</div>
</body>
</html>