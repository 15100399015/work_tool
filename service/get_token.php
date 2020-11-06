<?php
header("Content-type: text/plain; charset=utf-8");
header('Access-Control-Allow-Origin: *');
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}
if (is_get()) {
    $pr = $_GET['pr'];
    $fileName = "tokens.json";
    if (isset($pr)) {
        if (file_exists($fileName)) {
            $fileValJson = json_decode(file_get_contents($fileName), true);
            for ($i = 0; $i < count($fileValJson); $i++) {
                $_pr = $fileValJson[$i]["pr"];
                $_tokens = $fileValJson[$i]["tokens"];
                if ($_pr == $pr) {
                    exit(json_encode($_tokens));
                }
            }
            exit("[]");
        } else {
            header("HTTP/1.1 500 Server Error");
            exit("toknes.json文件不存在！");
        }
    } else {
        header("HTTP/1.1 500 Server Error");
        exit("请检查参数");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
