<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\shanchuang\game\public/../application/admin\view\daili\erjinum.html";i:1565164744;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/favicon.ico">
    <link rel="Shortcut Icon" href="/favicon.ico"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>代理列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 代理管理 <span
        class="c-gray en">&gt;</span> 代理列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <a href="javascript:;" onclick="admin_add('添加二级代理','<?php echo url('admin/daili/adminadd'); ?>','800','500')"
           class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加二级代理</a>
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">代理列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">用户ID</th>
                <th width="100">登录名</th>
              	<!--<th width="100">3.8每日输赢（元）</th>-->
                <th width="100">大吃小每日输赢（元）</th>
                <th width="100">总提现（元）</th>
                <th width="100">总佣金（元）</th>
                <th width="100">加入时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($arr) || $arr instanceof \think\Collection || $arr instanceof \think\Paginator): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['id']; ?></td>
                <td><?php echo $vo['username']; ?></td>
              	<!--<td><?php echo round($vo['bjhuode'],2); ?></td>-->
                <td><?php echo round($vo['fthuode'],2); ?></td>
                <td><?php echo $vo['tixian']; ?></td>
                <td><?php echo round($vo['zongyj'],2); ?></td>
                <td><?php echo date("Y-m-d H:i:s",$vo['created']); ?></td>
                <td class="td-manage"><a title="编辑" href="javascript:;"
                                              onclick="admin_edit('管理员编辑','<?php echo url('admin/daili/changedlpwd',['id'=>$vo['id']]); ?>','1','800','500')"
                                              class="ml-5" style="text-decoration:none"><i
                        class="Hui-iconfont">&#xe6df;编辑</i></a>

                        <a title="编辑" href="javascript:;"
                                              onclick="admin_edit('管理员编辑','<?php echo url('admin/daili/changebili',['id'=>$vo['id']]); ?>','1','800','500')"
                                              class="ml-5" style="text-decoration:none"><i
                        class="Hui-iconfont">修改比例</i></a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
   
    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/static/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/static/lib/laypage/1.2/laypage.js"></script>
    <script type="text/javascript">
        /*
            参数解释：
            title	标题
            url		请求的url
            id		需要操作的数据id
            w		弹出层宽度（缺省调默认值）
            h		弹出层高度（缺省调默认值）
        */
        /*管理员-增加*/
        function admin_add(title, url, w, h) {
            layer_show(title, url, w, h);
        }

        /*管理员-编辑*/
        function admin_edit(title, url, id, w, h) {
            layer_show(title, url, w, h);
        }

    </script>
</body>
</html>