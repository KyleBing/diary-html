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

// 传 email 是为了避免，邮件正确，日记id不对的情况

if (checkLogin($_COOKIE['diaryEmail'], $_COOKIE['diaryToken'])) {
    switch ($_REQUEST['type']) {
        case 'query':
            queryDiary($_COOKIE['diaryUid'], $_GET['diaryId']);
            break;
        case 'modify':
            updateDiary($_COOKIE['diaryUid'], $_POST['diaryId'], $_POST['diaryContent'], $_POST['diaryCategory'], $_POST['diaryDate']);
            break;
        case 'add':
            addDiary($_COOKIE['diaryUid'], $_POST['diaryContent'], $_POST['diaryCategory'], $_POST['diaryDate']);
            break;
        case 'delete':
            deleteDiary($_COOKIE['diaryUid'], $_POST['diaryId']);
            break;
        case 'search':
        case 'list':
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $category = isset($_GET['diaryCategory']) ? $_GET['diaryCategory'] : '';
            searchDiary($_COOKIE['diaryUid'], $category, $keyword, $_GET['pageCount'], $_GET['pageNo']);
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



// 搜索，展示日记
function searchDiary($uid, $category, $keyword, $pageCount, $pageNo)
{
    $startPoint = ($pageNo - 1) * $pageCount;
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::SearchDiaries($uid, $category, $keyword, $startPoint, $pageCount));
    if ($result) {
        $response = new ResponseSuccess();
        $diaries = $result->fetch_all(1); // 参数1会把字段名也读取出来
        $response->setData($diaries);
    } else {
        $response = new ResponseError();
    }
    echo $response->toJson();
    $con->close();
}

//查询日记内容
function queryDiary($uid, $id)
{
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::QueryDiaries($uid, $id));
    if ($result) {
        $response = new ResponseSuccess();
        $diaries = $result->fetch_all(1); // 参数1会把字段名也读取出来
        $response->setData($diaries);
    } else {
        $response = new ResponseError();
    }
    echo $response->toJson();
    $con->close();
}


//修改
function updateDiary($uid, $id, $content, $category, $date)
{
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::UpdateDiary($uid, $id, $content, $category, $date));
    if ($result) {
        $response = new ResponseSuccess('修改成功');
    } else {
        $response = new ResponseError('修改失败');
    }
    echo $response->toJson();
    $con->close();
}


// 删除
function deleteDiary($uid, $id)
{
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::DeleteDiary($uid, $id));
    if ($result) {
        $response = new ResponseSuccess('删除成功');
    } else {
        $response = new ResponseError('删除失败');
    }
    echo $response->toJson();
    $con->close();
}


// 添加
function addDiary($uid, $content, $category, $date)
{
    $con = new dsqli();
    $con->set_charset('utf8');
    $response = '';
    $result = $con->query(MSql::AddDiary($uid, $content, $category, $date));
    if ($result) {
        $response = new ResponseSuccess('添加成功');
    } else {
        $response = new ResponseError('添加失败');
    }
    echo $response->toJson();
    $con->close();
}


