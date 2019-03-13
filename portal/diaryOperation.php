<?php
/**
 * 日记的相关操作方法
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-13
 * Time: 19:24
 */

require "class/Response.php";
require "class/MSql.php";
require "common.php";


switch ($_GET['type']){
    case 'query':
        if ($_GET['uuid'] === 'kylebing'){
//        if (checkLogin($_GET['email'],$_GET['uuid'])){
            queryDiaries($_GET['pageCount'],$_GET['pageNo']);
        } else {
            echo json_encode(new ResponseError('密码错误，请重新登录'));
        }
        break;
    case 'update':
        updatePassword($_GET['email'],$_GET['oldPassword'],$_GET['newPassword']);
        break;
    case 'add':
        updatePassword($_GET['email'],$_GET['oldPassword'],$_GET['newPassword']);
        break;
    case 'delete':
        updatePassword($_GET['email'],$_GET['oldPassword'],$_GET['newPassword']);
        break;
    default:
        echo json_encode(new ResponseError('请求参数错误'));
        break;
}


function queryDiaries($pageCount,$pageNo)
{
    $con = new mysqli(HOST,USER,PASSWORD,DATABASE,PORT);
    $startPoint = ($pageNo -1 ) * $pageCount;
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::QueryDiaries($startPoint, $pageCount));
    if ($result) {
        $response = new ResponseSuccess();
        $diaries =  $result->fetch_all(1); // 参数1会把字段名也读取出来
        $response->setData($diaries);
    } else {
        $response = new ResponseError();
    }
    echo json_encode($response);
    $con->close();
}

function updateDiary($diaryId, $diaryContent,$diaryCategory){

}
