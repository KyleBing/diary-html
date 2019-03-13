<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 18:00
 */

date_default_timezone_set('Asia/Shanghai');

define('HOST',      'localhost');
define('PORT',      '3306');
define('DATABASE',  'diary');
define('USER',      'root');
define('PASSWORD',  'nnqi');

 class MSql
{


     /************************* 日记操作 *************************/

     // 查询日记
     public static function QueryDiaries($startPoint, $pageCount)
     {
         return "select * from diaries limit $startPoint, $pageCount";
     }


     /************************* 用户操作 *************************/

     //  更新密码
     public static function UpdateUserPassword($email, $password)
     {
         return "update users set `password` = '${password}' where email='${email}'";
     }

     // 查询密码
     public static function QueryUserPassword($email)
     {
         return "select password from users where email='${email}'";
     }

     //  新增用户
     public static function InsetNewUser($email, $password)
     {
         $timeNow = date('Y-m-d H:i:s');
         return "insert into users(email, password, register_time) VALUES ('${email}','${password}','${timeNow}' )";
     }

     // 查询用户是否存在
     public static function QueryEmailExitance($email)
     {
         return "select email from users where email='${email}'";
     }

}

