<?php
error_reporting(0);
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,OPTIONS'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段
$weixin = '';
$file = "weixin.txt";
if (file_exists($file)) {
    $weixin = file_get_contents("weixin.txt");
} else {
    $weixin = '[]';
}
?>
let weixins = <?php echo $weixin ?>;
window.wxh = weixins[Math.floor(Math.random()*weixins.length)];