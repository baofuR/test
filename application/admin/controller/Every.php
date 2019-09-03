<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
class Every extends Controller
{
    public function every()
    {
        Db::execute("update tp_admin set mryongjin=0");
    }
}