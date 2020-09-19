<?php
error_reporting(0);
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:GET,OPTIONS'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
}

if (is_get()) {
    $file = file_exists("weixin.txt"); //判断文件是否存在;
    if ($file) {
        $weixin = file_get_contents("weixin.txt");
        trim($weixin);
        exit($weixin);
    } else {
        exit("[]");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
