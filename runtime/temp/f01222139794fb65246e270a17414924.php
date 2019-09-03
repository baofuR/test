<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\shanchuang\game\public/../application/admin\view\kcmember\memberlist.html";i:1565775020;}*/ ?>
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
    <title>开船用户列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 开船用户列表 <span
        class="c-gray en">&gt;</span> 开船用户列表 <a class="btn btn-success radius r"
                                                style="line-height:1.6em;margin-top:3px"
                                                href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <form class="form form-horizontal" id="form-admin-add" method="post" action="">
            <div class="row cl">
                <label class="form-label col-sm-3"><span class="c-red">*</span>管理员：</label>
                <div class="formControls col-sm-9">
                    <input type="text" class="input-text" placeholder="搜索用户id" name="id" style="width:200px">
                    <input class="btn" value="查询" type="submit">
                </div>
            </div>
        </form>
      <span><a href="<?php echo url('admin/kcmember/memberlist?sort=balance'); ?>" class="btn btn-primary radius"><i class="Hui-iconfont"></i> 余额排行</a></span>
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">用户列表</th>
            </tr>
            <tr class="text-c">
                <th width="100">用户ID</th>
                <th width="100">上级ID</th>
                <th width="100">openid</th>
                <th width="100">昵称</th>
                <th width="100">头像</th>
                <th width="100">性别</th>
                <th width="100">余额（元）</th>
                <th width="100">总充值（元）</th>
                <th width="100">提现总金额（元）</th>
                <th width="100">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['id']; ?></td>
                <td><?php echo $vo['utid']; ?></td>
                <td><?php echo $vo['openid']; ?></td>
                <td><?php echo $vo['nickname']; ?></td>
                <td><img src="<?php echo $vo['headimgurl']; ?>" width="54" height="54"></td>
                <td>
                    <?php switch($vo['sex']): case "1": ?>男<?php break; case "2": ?>女<?php break; endswitch; ?>
                </td>
                <td><?php echo round($vo['balance'],2); ?></td>
                <td><?php echo $vo['chongzhi']; ?></td>
                <td><?php echo $vo['zongtx']; ?></td>
                <td><?php switch($vo['status']): case "0": ?>正常<?php break; case "1": ?>禁止进入<?php break; endswitch; ?>
                </td>
                <td><a title="编辑" href="javascript:;"
                       onclick="member_edit('用户编辑','<?php echo url('admin/kcmember/edit',['id'=>$vo['id']]); ?>','1')" class="ml-5"
                       style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;编辑</i></a> &nbsp;&nbsp;&nbsp;&nbsp;
                    <a title="编辑" href="javascript:;"
                       onclick="member_edit('查看下注记录','<?php echo url('admin/kcmember/viewxiazhu',['id'=>$vo['id']]); ?>','1')"
                       class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">查看下注记录</i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a title="编辑" href="javascript:;"
                       onclick="member_edit('查看详情','<?php echo url('admin/kcmember/viewinfo',['id'=>$vo['id']]); ?>','1')"
                       class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">查看详情</i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php switch($vo['status']): case "0": ?><a href="JavaScript:jinzhi('<?php echo $vo['id']; ?>', 1)" style="color: #3300FF">禁止进入</a><?php break; case "1": ?><a href="JavaScript:quxiao('<?php echo $vo['id']; ?>', 0)" style="color: #CC0033">取消</a><?php break; endswitch; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a title="删除"
                       href="<?php echo url('admin/member/userdel_kc',['id'=>$vo['id']]); ?>"
                       onclick="return confirm('是否确认删除')" class="ml-5"
                       style="text-decoration:none"><i class="Hui-iconfont">删除</i></a>
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
        function member_edit(title, url, id, w, h) {
            layer_show(title, url, w, h);
        }

        function jinzhi(id, status) {

            $.ajax({
                url: "<?php echo url('jinzhigame'); ?>",
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

        function quxiao(id, status) {

            $.ajax({
                url: "<?php echo url('jiechu'); ?>",
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
    </script>
</body>
</html>