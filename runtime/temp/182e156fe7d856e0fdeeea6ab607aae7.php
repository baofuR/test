<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\shanchuang\game\public/../application/admin\view\index\index.html";i:1565748912;}*/ ?>
﻿<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" type="text/css" href="/static/admin/zoomify.css"/>
    <link rel="Bookmark" href="/favicon.ico">
    <link rel="Shortcut Icon" href="/favicon.ico"/>
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
    <title>后台管理</title>
    <!--<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">-->
    <!--<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">-->
	<style>
		.modal-alert{
			position: fixed !important;
			right: 20px !important;
			bottom: 20px !important;
			left: auto !important;
			top: auto !important;
		}
	</style>
</head>
<body onload="welcome()">
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs"
                                           href="<?php echo url('admin/index/index'); ?>">后台管理</a><span
                class="logo navbar-slogan f-l mr-10 hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                class="btn btn-success radius r"
                style="line-height:1.6em;margin-top:3px"
                href="javascript:location.replace(location.href);"
                title="刷新"><i
                class="Hui-iconfont">&#xe68f;</i></a></span>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs"><?php switch($data['guanlitype']): case "1": ?><!--<font size="5" color="red">未提现：</font>--><?php break; endswitch; ?></span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>
                        <?php switch($data['guanlitype']): case "1": ?>超级管理员<?php break; case "2": ?>一级代理<?php break; case "3": ?>二级代理<?php break; case "4": ?>三级代理<?php break; endswitch; ?>
                    </li>
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A"><?php echo session('admin.username'); ?><i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                          <li><a title="编辑" href="javascript:;"
                                   onclick="admin_edit('管理员编辑','<?php echo url('admin/user/changepwd'); ?>','1','800','500')"
                                   class="ml-5" style="text-decoration:none">修改密码</a></li>
                            <li><a href="<?php echo url('admin/user/logout'); ?>">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"><a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-admin">
            <?php switch($data['guanlitype']): case "1": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('admin/user/userlist'); ?>" data-title="管理员列表"
                           href="javascript:void(0)">
                        管理员列表
                    </a></li>
                    <li><a data-href="<?php echo url('admin/shuju/showshuju'); ?>" data-title="数据统计"
                           href="javascript:void(0)">
                        数据统计
                    </a></li>
                    <li><a data-href="<?php echo url('admin/user/dailinum'); ?>" data-title="代理列表"
                           href="javascript:void(0)">
                        代理列表
                    </a></li>
                  <li><a data-href="<?php echo url('admin/user/erji'); ?>" data-title="二级代理"
                           href="javascript:void(0)">
                        二级代理
                    </a></li>
                    <li><a data-href="<?php echo url('admin/user/sanji'); ?>" data-title="三级代理"
                           href="javascript:void(0)">
                        三级代理
                    </a></li>
					<li><a id="welcome" data-href="<?php echo url('admin/index/welcome'); ?>" data-title="后台首页"
						   href="javascript:void(0)">后台首页</a></li>
                </ul>
            </dd>
            <?php break; case "2": break; case "3": break; endswitch; ?>
        </dl>
        <!--<dl id="menu-admin">
            <?php switch($data['guanlitype']): case "1": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 3.8用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "2": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 3.8用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "3": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 3.8用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "4": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 3.8用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; endswitch; ?>

            <dd>
                <ul>
                    <li>
                        <a data-href="<?php echo url('admin/member/memberlist'); ?>" data-title="3.8用户列表" href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "1": ?>用户列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li>
                        <a data-href="<?php echo url('admin/daili/xiajinum'); ?>" data-title="3.8下级列表" href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "2": ?>3.8下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li>
                        <a data-href="<?php echo url('admin/erjidaili/xiajinum'); ?>" data-title="3.8下级列表"
                           href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "3": ?>3.8下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li>
                        <a data-href="<?php echo url('admin/sanjidaili/xiajinum'); ?>" data-title="3.8下级列表"
                           href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "4": ?>3.8下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                </ul>
            </dd>
        </dl>-->
        <dl id="menu-admin">
            <?php switch($data['guanlitype']): case "1": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 大吃小用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "2": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 大吃小用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "3": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 大吃小用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; case "4": ?>
            <dt><i class="Hui-iconfont">&#xe62d;</i> 大吃小用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <?php break; endswitch; ?>

            <dd>
                <ul>
                    <li>
                        <a data-href="<?php echo url('admin/kcmember/memberlist'); ?>" data-title="大吃小用户列表"
                           href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "1": ?>用户列表<?php break; endswitch; ?>
                        </a>
                    </li>

                    <li>
                        <a data-href="<?php echo url('admin/daili/kcxiajinum'); ?>" data-title="大吃小下级列表" href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "2": ?>大吃小下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li>
                        <a data-href="<?php echo url('admin/erjidaili/kcxiajinum'); ?>" data-title="大吃小下级列表"
                           href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "3": ?>大吃小下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li>
                        <a data-href="<?php echo url('admin/sanjidaili/kcxiajinum'); ?>" data-title="大吃小下级列表"
                           href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "4": ?>大吃小下级列表<?php break; endswitch; ?>
                        </a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe613;</i>
                <?php switch($data['guanlitype']): case "1": ?>记录管理<?php break; case "2": ?>团队管理<?php break; case "3": ?>团队管理<?php break; case "4": ?>团队管理<?php break; endswitch; ?>
                <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <!--<li><a data-href="<?php echo url('admin/record/recordlist'); ?>" data-title="3.8记录列表" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>3.8记录列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>-->
                    <li><a data-href="<?php echo url('admin/record/kcrecordlist'); ?>" data-title="大吃小大众房记录列表"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>大吃小大众房记录列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
					<li><a data-href="<?php echo url('admin/record/kcyjrecordlist'); ?>" data-title="大吃小约局房记录列表"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>大吃小约局房记录列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                  	<li><a data-href="<?php echo url('admin/record/kcviprecordlist'); ?>" data-title="大吃小VIP房记录列表"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>大吃小VIP房记录列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                    <!--<li><a data-href="<?php echo url('admin/record/chongzhilist'); ?>" data-title="3.8充值列表"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>3.8充值列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>-->
                    <li><a data-href="<?php echo url('admin/record/kcchongzhilist'); ?>" data-title="大吃小充值列表"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>大吃小充值列表<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/record/dltixian'); ?>" data-title="代理提现记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>代理提现记录<?php break; endswitch; ?>
                    </a></li>
                    <!--<li><a data-href="<?php echo url('admin/record/usertixian'); ?>" data-title="3.8用户提现记录"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>3.8用户提现记录<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>-->
                    <li><a data-href="<?php echo url('admin/record/kcusertixian'); ?>" data-title="大吃小用户提现记录"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>大吃小用户提现记录<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/record/xiafen'); ?>" data-title="后台下分记录"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>后台下分记录<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/record/jianyj'); ?>" data-title="后台减佣金记录"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "1": ?>后台减佣金记录<?php break; case "2": break; case "3": break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/daili/xiangguan'); ?>" data-title="相关统计" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "2": ?>相关统计<?php break; endswitch; ?>
                    </a></li>
                    <li>
                        <a data-href="<?php echo url('admin/daili/erjinum'); ?>" data-title="代理列表" href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "2": ?>代理列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li><a data-href="<?php echo url('admin/daili/tixian'); ?>" data-title="佣金提现" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "2": ?>佣金提现<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/daili/erjitixian'); ?>" data-title="二级代理提现记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "2": ?>二级代理提现记录<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/daili/jyjrecord'); ?>" data-title="后台减佣金记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "2": ?>后台减佣金记录<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/daili/showtxcode'); ?>" data-title="上传佣金提现码" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "2": ?>上传佣金提现码<?php break; endswitch; ?>
                    </a></li>

                    <!--二级代理-->
                    <li><a data-href="<?php echo url('admin/erjidaili/xiangguan'); ?>" data-title="相关统计" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "3": ?>相关统计<?php break; endswitch; ?>
                    </a></li>
                    <li>
                        <a data-href="<?php echo url('admin/erjidaili/sanjinum'); ?>" data-title="代理列表" href="javascript:void(0)">
                            <?php switch($data['guanlitype']): case "3": ?>代理列表<?php break; endswitch; ?>
                        </a>
                    </li>
                    <li><a data-href="<?php echo url('admin/erjidaili/tixian'); ?>" data-title="佣金提现" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "3": ?>佣金提现<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/sanjitixian'); ?>" data-title="三级代理提现记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "3": ?>三级代理提现记录<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/showtxcode'); ?>" data-title="上传佣金提现码"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "3": ?>上传佣金提现码<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/jyjrecord'); ?>" data-title="后台减佣金记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "3": ?>后台减佣金记录<?php break; endswitch; ?>
                    </a></li>

                    <!--三级代理-->
                    <li><a data-href="<?php echo url('admin/erjidaili/xiangguan'); ?>" data-title="相关统计" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "4": ?>相关统计<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/tixian'); ?>" data-title="佣金提现" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "4": ?>佣金提现<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/showtxcode'); ?>" data-title="上传佣金提现码"
                           href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "4": ?>上传佣金提现码<?php break; endswitch; ?>
                    </a></li>
                    <li><a data-href="<?php echo url('admin/erjidaili/jyjrecord'); ?>" data-title="后台减佣金记录" href="javascript:void(0)">
                        <?php switch($data['guanlitype']): case "4": ?>后台减佣金记录<?php break; endswitch; ?>
                    </a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <?php switch($data['guanlitype']): case "1": ?>
            <dt><i class="Hui-iconfont">&#xe613;</i> 系统配置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <?php break; case "2": break; case "3": break; endswitch; ?>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('admin/kefu/index'); ?>" data-title="上传客服图片"
                           href="javascript:void(0)">上传客服图片</a></li>
                    <li><a data-href="<?php echo url('admin/Ptaiconfig/save'); ?>" data-title="后台设置"
                           href="javascript:void(0)">后台设置</a></li>
                    <li><a data-href="<?php echo url('admin/fengding/showfd'); ?>" data-title="房间下注封顶"
                           href="javascript:void(0)">房间下注封顶</a></li>
                    <li><a data-href="<?php echo url('admin/clear/index'); ?>" data-title="清空数据"
                           href="javascript:void(0)">清空数据</a></li>
                    <li><a data-href="<?php echo url('admin/sys/save'); ?>" data-title="房间维护"
                           href="javascript:void(0)">房间维护</a></li>
                  	<li><a data-href="<?php echo url('admin/roompwd/showpwd'); ?>" data-title="房间维护"
                           href="javascript:void(0)">房间密码</a></li>
                </ul>
            </dd>
            <ul class="dropDown-menu menu radius box-shadow">
                <li><a data-href="<?php echo url('admin/user/logout'); ?>" data-title="退出">退出</a></li>
            </ul>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
</div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="" style="display: none">
                    <span title="我的桌面" data-href="">我的桌面</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S"
                                                  href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a
                id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a>
        </div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src=""></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前</li>
        <li id="closeall">关闭全部</li>
    </ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/static/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
	function welcome(){
		document.getElementById("welcome").click();
	}
	function modalalertdemo(){
		$.Huimodalalert('你有新的订单未处理！',60000);
	}
      /*管理员-编辑*/
    function admin_edit(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
</script>
<!--/此乃百度统计代码，请自行删除-->
</body>
</html>