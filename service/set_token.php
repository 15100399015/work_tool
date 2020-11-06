<?php
header("Content-type: text/plain; charset=utf-8");
header('Access-Control-Allow-Origin: *');
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
}
if (is_post()) {
    $pr = $_POST['pr'];
    $tokens = explode(",", $_POST['tokens']);
    if (isset($tokens) && isset($pr)) {
        $fileName = "tokens.json";
        if (!file_exists($fileName)) {
            fopen($fileName, "w");
        }
        if (is_writable($fileName)) {
            $fileValJson = json_decode(file_get_contents($fileName), true);
            $findSign = 0;
            for ($i = 0; $i < count($fileValJson); $i++) {
                $_pr = $fileValJson[$i]["pr"];
                $_tokens = $fileValJson[$i]["tokens"];
                if ($_pr == $pr) {
                    $findSign = 1;
                    $fileValJson[$i]["tokens"] = $tokens;
                }
            }
            if ($findSign === 0) {
                array_push($fileValJson, array('pr' => $pr, 'tokens'  => $tokens));
            }
            if (file_put_contents($fileName, json_encode($fileValJson))) {
                exit('200');
            } else {
                header("HTTP/1.1 500 Server Error");
                exit("更新失败!");
            }
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
