<?php
/**
 * 通用方法
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-13
 * Time: 20:11
 */

// 验证是否已登录
function checkLogin($email, $uuid){
    $con = new mysqli(HOST,USER,PASSWORD,DATABASE,PORT);
    $result = $con->query(MSql::QueryUserPassword($email));
    if ($result) {
        if ($result->num_rows !== 0) { // 存在用户
            $row = $result->fetch_array();
            if (password_verify($uuid, $row[password])) {
                return true;
            }
        }
    }
    $con->close();
    return false;
}
