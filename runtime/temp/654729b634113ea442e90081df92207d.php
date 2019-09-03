<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\shanchuang\game\public/../application/admin\view\record\dltixian.html";i:1564844972;}*/ ?>
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
    <link rel="stylesheet" type="text/css" href="/static/admin/zoomify.css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <script type="text/javascript" src="/static/bootstrap/bootstrap.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/static/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>代理提现列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 代理提现列表 <span
        class="c-gray en">&gt;</span> 代理提现列表 <a class="btn btn-success radius r"
                                                 style="line-height:1.6em;margin-top:3px"
                                                 href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <!--<form class="form form-horizontal" id="form-admin-add" method="post" action="">-->
        <!--<div class="row cl">-->
        <!--<label class="form-label col-sm-3"><span class="c-red">*</span>管理员：</label>-->
        <!--<div class="formControls col-sm-9">-->
        <!--<input type="text" class="input-text" placeholder="搜索用户id" name="id" style="width:200px">-->
        <!--<input class="btn" value="查询" type="submit">-->
        <!--</div>-->
        <!--</div>-->
        <!--</form>-->
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">代理提现列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">用户ID</th>
                <th width="100">昵称</th>
                <th width="100">提现码</th>
                <th width="100">金额（元）</th>
                <th width="100">状态</th>
                <th width="100">时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['userid']; ?></td>
                <td><?php echo $vo['username']; ?></td>
                <td><img src="http://<?php echo $_SERVER['SERVER_NAME'];?>/dltixianma/<?php echo $vo['tixianma']; ?>" width="54" height="100" class="zoomify"></td>
                <td><?php echo $vo['jine']; ?></td>
                <td><?php switch($vo['status']): case "1": ?>未提现<?php break; case "2": ?>已提现<?php break; endswitch; ?>
                </td>
                <td><?php echo date("Y-m-d H:i:s",$vo['time']); ?></td>

                <td><a href="JavaScript:tongguo('<?php echo $vo['id']; ?>', 2)" style="color: #3300FF">确认提现</a></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo $data->render(); ?>
    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="/static/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/static/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/static/lib/laypage/1.2/laypage.js"></script>
    <script type="text/javascript" src="/static/admin/tupian.js"></script>
    <script type="text/javascript" src="/static/admin/zoomify.js"></script>
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
        $(function(){
            $('img').zoomify();
        });
        function tongguo(id) {

            $.ajax({
                url: "<?php echo url('dlquerentx'); ?>",
                type: 'get',
                data: {"id": id},
                success: function (result) {
                    alert('确认提现?')
                    window.location.reload()
                },
                error: function () {
                    alert('失败, 请重试')
                }
            })
        }
    </script>
</body>
</html>