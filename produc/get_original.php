<?php
header("Content-type: text/plain; charset=utf-8");
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}
function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (is_get()) {
    if (file_exists("weixin.txt")) {
        $weixin = file_get_contents("weixin.txt");
        trim($weixin);
        // 判断是否是一个合法的json数组
        if (
            (strpos($weixin, "[") == 0)
            &&
            is_json($weixin)
        ) {
            exit($weixin);
        } else {
            exit("[]");
        }
    } else {
        exit("[]");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
