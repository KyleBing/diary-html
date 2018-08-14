<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018-08-5
 * Time: 09:13
 */

date_default_timezone_set('Asia/Shanghai');

//configuration
$host=          "127.0.0.1";
$port =         '3306';
$database =     "diary";
$user =         "root";
$passwd =       "nnqi";


$email    = $_POST["email"];
$password = $_POST["password"];
$type     = $_POST["type"];

/*
- verify email
    - exist return false
    - success register and return success
*/


switch ($type) {
    case "register" :
        $result = register_user($email, $password);
        echo json_encode($result);
        break;
    case "login":
        $result = login_user($email, $password);
        echo json_encode($result);
        break;
    default: break;
}



//login
function login_user($login_email,$login_password){
    global $host,$user,$passwd,$database;

    $sql = "select * from USER where email='$login_email'";
    $con = new mysqli( $host, $user, $passwd, $database);
    $con->set_charset('utf8');

    $response = new Response();
    $result = $con->query($sql);

    // 查询正确
    if($result){
        $response -> query_status = true;

        // 匹配到用户
        if ($result->num_rows>0){
            $response->exist = true;
            $record = $result->fetch_object();

            // 密码匹配
            if ($record->password == $login_password){
                $response->login_status = true;
                $now_time = date('Y-m-d H:i:s');
                $update_login_time_sql = "update user set last_visit_time='$now_time' where email='$login_email'"; //更新最后访问时间
                $con->query($update_login_time_sql);
            } else {

                // 密码错误
                $response->login_status = false;
            }
        } else {
            // 未匹配到用户
            $response->exist = false;
        }
    } else {
        // 查询不正确
        $response->query_status = false;
    }
    $con->close();
    return $response;
}


// Register New User
// 返回 RegResponse 状态对象
function register_user($reg_email,$reg_password){
    global $host,$user,$passwd,$database;

    $sql = "select email from USER where email='$reg_email'";
    $con = new mysqli( $host, $user, $passwd, $database);
    $con->set_charset('utf8');

    $response = new RegResponse();
    $result = $con->query($sql);
    if($result){
        $response -> query_status = true;
        if ($result->num_rows>0){
            $response->exist = true;
        } else {
            $response->exist = false;
            $now_time = date('Y-m-d H:i:s');
            $add_sql = "insert into user(email, password, register_time) VALUES ('$reg_email','$reg_password','$now_time' )";
            if ($con->query($add_sql)) {
                $response->add_status = true;
            } else {
                $response->add_status = false;
            }
        }
    } else {
        $response->query_status = false;
    }
    $con->close();
    return $response;
}







//Other Test Functions
function echo_msg($words){
    print ("<h2>".$words."</h2>");
}

class Response{
    public $query_status = false;
    public $exist = false;
    public $add_status = false;
    public $login_status = false;
}

?>