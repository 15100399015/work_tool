<?php
header("Content-type: text/plain; charset=utf-8");
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
}
function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

if (is_post()) {
    // 验证传毒的字符串
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
    // 去除空白字符
    trim($data);
    // 判断是不是一个合法的json数组
    if (
        (strpos($data, "[") == 0)
        &&
        is_json($data)
    ) {
        return $data;
    } else {
        return NULL;
    }
}
