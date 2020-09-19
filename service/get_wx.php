<?php
header("Content-type: application/javascript; charset=utf-8");
header("Access-Control-Allow-Origin: *");
// 判断是否为json
function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
$weixin = '';
// 被读取的文件
$file = "weixin.txt";
// 文件是否存在
if (file_exists($file)) {
    // 读取文件内容
    $fileVal = file_get_contents($file);
    trim($fileVal);
    // 判断是否是一个合法的json数组
    if (
        (strpos($fileVal, "[") == 0)
        &&
        is_json($fileVal)
    ) {
        // 是一个合法的json数组
        $weixin = $fileVal;
    } else {
        $weixin = '[]';
    }
} else {
    $weixin = '[]';
}
?>
let weixins = <?php echo $weixin ?>;
window.wxh = weixins[Math.floor(Math.random()*weixins.length)];