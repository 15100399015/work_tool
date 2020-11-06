<?php
header("Content-type: text/plain; charset=utf-8");
header('Access-Control-Allow-Origin: *');
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}
if (is_get()) {
    $token = $_GET['token'];
    $fileName = "tokens.json";
    $resObj = array('existence' => false, 'pr' => array());
    if (isset($token)) {
        if (file_exists($fileName)) {
            $fileValJson = json_decode(file_get_contents($fileName), true);
            for ($i = 0; $i < count($fileValJson); $i++) {
                $_pr = $fileValJson[$i]["pr"];
                $_tokens = $fileValJson[$i]["tokens"];
                if (in_array($token, $_tokens, false)) {
                    $resObj["existence"] = true;
                    array_push($resObj["pr"], $_pr);
                }
            }
            exit(json_encode($resObj));
        } else {
            header("HTTP/1.1 500 Server Error");
            exit("不可写入!请修改权限后重试!");
        }
    } else {
        header("HTTP/1.1 500 Server Error");
        exit("请检查参数");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
