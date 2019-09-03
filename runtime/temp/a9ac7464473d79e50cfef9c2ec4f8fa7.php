<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\shanchuang\game\public/../application/admin\view\shuju\showshuju.html";i:1565748732;}*/ ?>
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
    <title>数据统计</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 数据统计 <span
        class="c-gray en">&gt;</span> 数据统计 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="19">数据统计</th>
            </tr>
            <tr class="text-c">
                <th width="100">每日充值（元）</th>
                <th width="100">每日提现（元）</th>
                <th width="100">每日代理佣金（元）</th>
              <th width="100">每日下注人数（人）</th>
                <!--<th width="100">3.8 4.0充值（元）</th>
                <th width="100">3.8 4.0提现（元）</th>
                <th width="100">3.8 4.0余分（元）</th>
                <th width="100">3.8 4.0盈亏（元）</th>-->
                <th width="100">大吃小充值（元）</th>
                <th width="100">大吃小提现（元）</th>
                <th width="100">大吃小抽水（元）</th>
              <th width="100">大吃小本月抽水（元）</th>
                <th width="100">大吃小上月抽水（元）</th>
                <th width="100">大吃小余分（元）</th>
                <!--<th width="100">3.8 4.0佣金（元）</th>-->
                <th width="100">大吃小佣金（元）</th>
                <th width="100">代理提现（元）</th>
                <th width="100">总后台手动下分（元）</th>
                <th width="100">总后台下佣金（元）</th>
                <th width="100">微信总充值（元）</th>
                <th width="100">支付宝总充值（元）</th>
                <th width="100">后台手动总充值（元）</th>
            </tr>
            </thead>
            <tbody>

            <tr class="text-c">
                <td><?php echo $data['zmrsyschongzhi']; ?></td>
                <td><?php echo $data['zmrytx']; ?></td>
                <td><?php echo $data['mryongjin']; ?></td>
              <td><?php echo $data['count']; ?></td>
                <!--<td><?php echo $data['chongzhi']; ?></td>
                <td><?php echo $data['mrtx1']; ?></td>
                <td><?php echo $data['balance1']; ?></td>
                <td><?php echo $data['win']; ?></td>-->
                <td><?php echo $data['dcxchongzhi']; ?></td>
                <td><?php echo $data['mrtx2']; ?></td>
                <td><?php echo $data['dcxchoushui']; ?></td>
              <td><?php echo $data['csnowm']; ?></td>
                <td><?php echo $data['cslast']; ?></td>
                <td><?php echo $data['balance2']; ?></td>
                <!--<td><?php echo round($data['yongjin'],2); ?></td>-->
                <td><?php echo round($data['dcxyongjin'],2); ?></td>
                <td><?php echo $data['dltixian']; ?></td>
                <td><?php echo $data['adminxiafen']; ?></td>
                <td><?php echo $data['adminxiayj']; ?></td>
                <td><?php echo $data['wxchongzhi']; ?></td>
                <td><?php echo $data['zfbchongzhi']; ?></td>
                <td><?php echo $data['syschongzhi']; ?></td>
            </tr>

            </tbody>
        </table>
    </div>
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