<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\shanchuang\game\public/../application/admin\view\record\kcchongzhilist.html";i:1565748222;}*/ ?>
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
    <title>开船充值列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 开船充值列表 <span
        class="c-gray en">&gt;</span> 开船充值列表 <a class="btn btn-success radius r"
                                                style="line-height:1.6em;margin-top:3px"
                                                href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <form class="form form-horizontal" id="form-admin-add" method="get" action="">
            <div class="row cl">
                <label class="form-label col-sm-3"><span class="c-red">*</span>管理员：</label>
                <div class="formControls col-sm-9">
                    <input type="text" class="input-text" placeholder="搜索用户id" name="keywords" style="width:200px">
                    <input class="btn" value="查询" type="submit">
                </div>
            </div>
        </form>
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">充值列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">用户ID</th>
                <th width="100">昵称</th>
                <th width="100">头像</th>
                <th width="100">金额（元）</th>
                <th width="100">订单号</th>
                <th width="100">充值类型</th>
                <th width="100">时间</th>
              <th width="100">状态</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['userid']; ?></td>
                <td><?php echo $vo['nickname']; ?></td>
                <td><img src="<?php echo $vo['headimgurl']; ?>" width="54" height="54"></td>
                <td><?php switch($vo['ctype']): case "admin": ?><?php echo $vo['jine']; break; case "1": ?><?php echo $vo['jine']; break; case "2": ?><?php echo $vo['jine']; break; endswitch; ?>
                </td>
                <td><?php echo $vo['ddanhao']; ?></td>
                <td><?php switch($vo['ctype']): case "admin": ?>后台手动<?php break; case "1": ?>微信<?php break; case "2": ?>支付宝<?php break; endswitch; ?>
                </td>
                <td><?php echo date("Y-m-d H:i:s",$vo['dtime']); ?></td>
              <td><?php switch($vo['status']): case "0": ?><a title="充值" href="<?php echo url('admin/record/querensf',['id'=>$vo['id']]); ?>"
                                       onclick="return confirm('是否确认充值')" class="ml-5"
                                       style="text-decoration:none"><font color="blue">确认充值到账</font></a>
                    <a title="删除" href="<?php echo url('admin/record/deldingdan',['id'=>$vo['id']]); ?>"
                       onclick="return confirm('是否确认删除')" class="ml-5"
                       style="text-decoration:none"><font color="blue">删除</font></a><?php break; case "1": ?>已充值到账<?php break; endswitch; ?>
                </td>
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

        function shenqing(id, quanxian) {

            $.ajax({
                url: "<?php echo url('addquanxian'); ?>",
                type: 'get',
                data: {"id": id, "quanxian": quanxian},
                success: function (result) {

                    window.location.reload()
                },
                error: function () {
                    alert('失败, 请重试')
                }
            })
        }

        function qushenqing(id, quanxian) {

            $.ajax({
                url: "<?php echo url('delquanxian'); ?>",
                type: 'get',
                data: {"id": id, "quanxian": quanxian},
                success: function (result) {

                    window.location.reload()
                },
                error: function () {
                    alert('失败, 请重试')
                }
            })
        }

        function sjinyan(id, status) {

            $.ajax({
                url: "<?php echo url('addjinyan'); ?>",
                type: 'get',
                data: {"id": id, "status": status},
                success: function (result) {
                    window.location.reload()
                },
                error: function () {
                    alert('失败, 请重试')
                }
            })
        }

        function del(id) {

            $.ajax({
                url: "<?php echo url('deluser'); ?>",
                type: 'get',
                data: {"id": id},
                success: function (result) {

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