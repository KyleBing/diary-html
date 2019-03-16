<?php
/**
 * SQL 操作
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

     // 搜索日记
     public static function SearchDiaries($category, $keyword, $startPoint, $pageCount)
     {
         return "SELECT * from diaries where category like '%${category}%' AND content like '%${keyword}%' order by date desc  limit $startPoint, $pageCount";
     }

     // 添加日记
     public static function AddDiary($content, $category, $date)
     {
         $timeNow = date('Y-m-d H:i:s');
         return "INSERT into diaries(content,category,create_date,modify_date,date) VALUES('${content}','${category}','${timeNow}','${timeNow}','${date}')";
     }

     // 删除日记
     public static function DeleteDiary($id)
     {
         return "DELETE from diaries WHERE id='${id}'";
     }

     // 更新日记
     public static function UpdateDiary($id,$content,$category,$date)
     {
         $timeNow = date('Y-m-d H:i:s');
         return "update diaries set modify_date='${timeNow}', date='${date}', category='${category}',content='${content}' WHERE id='${id}'";
     }

     // 查询日记内容
     public static function QueryDiaries($id)
     {
         return "select * from diaries where id = '${id}'";
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

/**
 * dsqli 继承 mysqli
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 18:00
 */
class dsqli extends mysqli {
     public function __construct()
     {
         parent::__construct(HOST, USER, PASSWORD, DATABASE, PORT);
     }
}

