<?php
/**
 * SQL 操作
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 18:00
 */

date_default_timezone_set('Asia/Shanghai');

define('HOST', 'localhost');
define('PORT', '3306');
define('DATABASE', 'diary');
define('USER', 'root');
define('PASSWORD', 'nnqi');

class MSql
{

    public static $CREATEDIARIES = "CREATE TABLE `diaries` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `create_date` datetime NOT NULL,
                                  `content` varchar(255) NOT NULL,
                                  `action` enum('add','update','delete','synced') NOT NULL DEFAULT 'add',
                                  `category` enum('life','study','work','sport','bigevent','others') NOT NULL DEFAULT 'life',
                                  `modify_date` datetime DEFAULT NULL,
                                  `date` datetime NOT NULL,
                                  PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;";
    public static $CREATELOGINLOG = "CREATE TABLE `login_log` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `date` datetime NOT NULL,
                                  `email` varchar(50) NOT NULL,
                                  `password` varchar(30) NOT NULL,
                                  PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
    public static $CREATEUSERS = "CREATE TABLE `users` (
                                  `uid` int(11) NOT NULL AUTO_INCREMENT,
                                  `email` varchar(50) NOT NULL,
                                  `password` varchar(100) NOT NULL,
                                  `last_visit_time` datetime DEFAULT NULL,
                                  `name` varchar(50) DEFAULT NULL,
                                  `register_time` datetime DEFAULT NULL,
                                  PRIMARY KEY (`uid`,`email`)
                                ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";


    /************************* 日记操作 *************************/

    // 搜索日记
    public static function SearchDiaries($uid, $category, $keyword, $startPoint, $pageCount)
    {
        return "SELECT *
                  from diaries 
                  where uid='${uid}' 
                  and category like '%${category}%' 
                  and content like '%${keyword}%' 
                  order by date desc  
                  limit $startPoint, $pageCount";
    }

    // 添加日记
    public static function AddDiary($uid, $content, $category, $date)
    {
        $timeNow = date('Y-m-d H:i:s');
        return "INSERT into diaries(content,category,create_date,modify_date,date,uid)
                VALUES('${content}','${category}','${timeNow}','${timeNow}','${date}','${uid}')";
    }

    // 删除日记
    public static function DeleteDiary($uid, $id)
    {
        return "DELETE from diaries
                WHERE id='${id}'
                and uid='${uid}'";
    }

    // 更新日记
    public static function UpdateDiary($uid, $id, $content, $category, $date)
    {
        $timeNow = date('Y-m-d H:i:s');
        return "update diaries 
                set diaries.modify_date='${timeNow}', 
                  diaries.date='${date}', 
                  diaries.category='${category}',
                  diaries.content='${content}'
                WHERE id='${id}' and uid='${uid}'";
    }

    // 查询日记内容
    public static function QueryDiaries($uid, $id)
    {
        return "select * from diaries
                where uid = '${uid}' and id = '${id}'";
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
        return "select * from users where email='${email}'";
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

    /************************* 未注册用户 *************************/
    //  记录用户
    public static function InsertLoginLog($email, $password)
    {
        $timeNow = date('Y-m-d H:i:s');
        return "insert into login_log(email, password, date) VALUES ('${email}','${password}','${timeNow}' )";
    }

}

/**
 * dsqli 继承 mysqli
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 18:00
 */
class dsqli extends mysqli
{
    public function __construct()
    {
        parent::__construct(HOST, USER, PASSWORD, DATABASE, PORT);
    }

    public function query($query, $resultmode = MYSQLI_STORE_RESULT)
    {
        parent::query("SET NAMES 'utf8'");
        return parent::query($query, $resultmode);
    }
}

