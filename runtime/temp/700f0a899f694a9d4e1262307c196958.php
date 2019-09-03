<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\shanchuang\game\public/../application/admin\view\daili\xiangguan.html";i:1565164516;}*/ ?>
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
    <title>相关统计</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 相关统计 <span
        class="c-gray en">&gt;</span> 相关统计 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div align="center">
	<h3>【<a href="<?php echo url('admin/daili/ewm'); ?>">重新生成二维码</a>】</h3>
    <img width="500" src="http://<?php echo $_SERVER['SERVER_NAME'];?><?php echo $arr['erweima']; ?>">
</div>

<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <div class="row cl">

            </div>

        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">用户列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">总下属人员</th>
                <th width="100">每日充值（元）</th>
                <th width="100">总充值（元）</th>
                <!--<th width="100">3.8 4.0总佣金（元）</th>-->
                <th width="100">开船大吃小总佣金（元）</th>
                <th width="100">总佣金（元）</th>
                <th width="100">已提现佣金（元）</th>
            </tr>
            </thead>
            <tbody>

            <tr class="text-c">
                <td><?php echo $arr['num']; ?></td>
                <td><?php echo $arr['mrcz']; ?></td>
                <td><?php echo $arr['chongzhi']; ?></td>
                <!--<td><?php echo round($arr['yongjin'],2); ?></td>-->
                <td><?php echo round($arr['kcyongjin'],2); ?></td>
                <td><?php echo round($arr['zongyj'],2); ?></td>
                <td><?php echo round($arr['yitixian'],2); ?></td>
            </tr>
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
        function member_edit(title, url, id, w, h) {
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