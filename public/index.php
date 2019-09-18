<?php

if (!empty($_FILES)) {
    $up_arr = ['jpg','png','jpeg','gif','JPG','PNG','JPEG','GIF'];
    $files = $_FILES;
    foreach ($files as $v) {
        $extend = pathinfo($v['name']);
        $extend = strtolower($extend["extension"]);
        if (!in_array($extend, $up_arr)) {
            echo '文件上传失败';
            exit();
        }
    }
}


// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

