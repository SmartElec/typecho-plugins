<?php
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");
$rootDir = strstr( dirname(__FILE__), 'usr', TRUE );
require_once $rootDir . 'config.inc.php';
require_once $rootDir . 'var/Typecho/Common.php';
require_once $rootDir . 'var/Typecho/Request.php';
require_once $rootDir . 'var/Widget/Upload.php';

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$CONFIG['imagePathFormat'] = $CONFIG['scrawlPathFormat'] = $CONFIG['snapscreenPathFormat'] = 
$CONFIG['catcherPathFormat'] = $CONFIG['videoPathFormat'] = $CONFIG['filePathFormat'] = 
$CONFIG['imageManagerListPath'] = $CONFIG['fileManagerListPath']
Typecho_Request::getInstance()->getUrlPrefix() . Widget_Upload::UPLOAD_DIR;

$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    echo $result;
}