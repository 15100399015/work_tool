<?php
header("Content-type: text/plain; charset=utf-8");
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
}
function getRandName()
{
    $string = date('YmdHis');
    for ($i = 0; $i < 6; $i++) {
        switch (mt_rand(0, 2)) {
            case 0:
                $string .= chr(mt_rand(97, 122));   //小a
                break;
            case 1:
                $string .= chr(mt_rand(65, 90));   //大A
                break;
            case 2:
                $string .= mt_rand(0, 9);          //获取随机数
                break;
        }
    }
    return $string;
}
if (is_post()) {
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $dirName = "upload";
    if (
        (($fileType == "image/gif")
            || ($fileType == "image/jpeg")
            || ($fileType == "image/jpg")
            || ($fileType == "image/pjpeg")
            || ($fileType == "image/x-png")
            || ($fileType == "image/png"))
        && ($fileSize < 5242880)
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            header("HTTP/1.1 500 Server Error");
            exit("错误:" . $_FILES["file"]["error"] . "<br>");
        } else {
            // 新文件名
            $fileName = getRandName() .  "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], $dirName . "/" . $fileName);
            $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
            exit(dirname($url) . "/" . $dirName . "/" . $fileName);
        }
    } else {
        header("HTTP/1.1 500 Server Error");
        exit("非法的文件格式,或请求方式");
    }
} else {
    header("HTTP/1.1 500 Server Error");
    exit("请求方式错误");
}
