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


if (checkLogin($_COOKIE['diaryEmail'],$_COOKIE['diaryToken'])){
    switch ($_REQUEST['type']){
        case 'query':
            queryDiary($_GET['diaryId']);
            break;
        case 'modify':
            updateDiary($_POST['diaryId'],$_POST['diaryContent'],$_POST['diaryCategory'],$_POST['diaryDate']);
            break;
        case 'add':
            addDiary($_POST['diaryContent'],$_POST['diaryCategory'],$_POST['diaryDate']);
            break;
        case 'delete':
            deleteDiary($_POST['diaryId']);
            break;
        case 'search':
        case 'list':
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $category = isset($_GET['diaryCategory']) ? $_GET['diaryCategory'] : '';
            searchDiary($category, $keyword, $_GET['pageCount'], $_GET['pageNo']);
            break;
        default:
            $response = new ResponseError('请求参数错误');
            echo $response->toJson();
            break;
    }
} else {
    $response = new ResponseError('密码错误，请重新登录');
    $response->setLogined(false);
    echo $response->toJson();
}


//查询日记内容
function queryDiary($id)
{
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::QueryDiaries($id));
    if ($result) {
        $response = new ResponseSuccess();
        $diaries =  $result->fetch_all(1); // 参数1会把字段名也读取出来
        $response->setData($diaries);
    } else {
        $response = new ResponseError();
    }
    echo $response->toJson();
    $con->close();
}


//修改
function updateDiary($id,$content,$category,$date){
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::UpdateDiary($id,$content,$category,$date));
    if ($result) {
        $response = new ResponseSuccess('修改成功');
    } else {
        $response = new ResponseError('修改失败');
    }
    echo $response->toJson();
    $con->close();
}


// 删除
function deleteDiary($id){
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::DeleteDiary($id));
    if ($result) {
        $response = new ResponseSuccess('删除成功');
    } else {
        $response = new ResponseError('删除失败');
    }
    echo $response->toJson();
    $con->close();
}


// 添加
function addDiary($content,$category,$date){
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::AddDiary($content,$category,$date));
    if ($result) {
        $response = new ResponseSuccess('添加成功');
    } else {
        $response = new ResponseError('添加失败');
    }
    echo $response->toJson();
    $con->close();
}


// 搜索，展示日记
function searchDiary($category, $keyword, $pageCount, $pageNo){
    $startPoint = ($pageNo -1 ) * $pageCount;
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::SearchDiaries($category, $keyword, $startPoint, $pageCount));
    if ($result) {
        $response = new ResponseSuccess();
        $diaries =  $result->fetch_all(1); // 参数1会把字段名也读取出来
        $response->setData($diaries);
    } else {
        $response = new ResponseError();
    }
    echo $response->toJson();
    $con->close();
}
