<?php
error_reporting(0);
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,OPTIONS'); // 允许请求的类型
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

if (is_post()) {
    $weixin = post_input($_POST['weixin']);
    if (isset($weixin)) {
        $file = "weixin.txt";
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        if (is_writable($file)) {
            if (file_get_contents($file) == $weixin) {
                header("HTTP/1.1 500 Server Error");
                exit("无需更新");
            }
            file_put_contents($file, $weixin);
            exit('200');
        } else {
            header("HTTP/1.1 500 Server Error");
            exit("不可写入!请修改权限后重试!");
        }
    } else {
        header("HTTP/1.1 500 Server Error");
        exit("请检查提交的数据");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
//过滤提交信息;
function post_input($data)
{
    return $data;
}
