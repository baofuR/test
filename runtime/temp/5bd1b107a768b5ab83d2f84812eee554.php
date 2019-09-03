<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\shanchuang\game\public/../application/admin\view\record\kcyjrecordlist.html";i:1557827820;}*/ ?>
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
    <title>大吃小约局记录列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 记录管理 <span
        class="c-gray en">&gt;</span> 每日下注记录 <a class="btn btn-success radius r"
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
                <th scope="col" colspan="9">大吃小约局记录列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">用户ID</th>
                <th width="100">昵称</th>
                <th width="100">期号</th>
                <th width="100">下注分数</th>
                <th width="100">增加分数</th>
                <th width="100">结算后余额</th>
              	<th width="100">点数</th>
                <th width="100">房间</th>
                <th width="100">桌号</th>
                <th width="100">时间</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['userid']; ?></td>
                <td><?php echo $vo['nickname']; ?></td>
                <td><?php echo $vo['qihao']; ?></td>
                <td><?php echo $vo['xiazhuzong']; ?></td>
                <td><?php echo round($vo['zengjia'],2); ?></td>
                <td><?php echo round($vo['xzhbalance'],2); ?></td>
              	<td>
				<script>
					var dianshu = "<?php echo $vo['dianshu']; ?>";
					var imgs = dianshu.split(","); //字符分割 
					for (i=0;i<imgs.length ;i++ ) 
					{ 
						document.write("<img width='22px' src='/static/admin/card/" + imgs[i] + ".png'>"); //分割后的字符输出 
					} 
				</script>
				</td>
                <td><?php switch($vo['roomid']): case "0": ?>大众房<?php break; case "1": ?>约局房<?php break; case "2": ?>VIP房<?php break; endswitch; ?>
                </td>
                <td><?php echo $vo['zhuohao']+1; ?></td>
                <td><?php echo date("Y-m-d H:i:s",$vo['time']); ?></td>
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