<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 16:40
 */

class User
{
    var $user_name;
    var $password;
    var $last_login;

    public function __construct($user_name)
    {
        $this->user_name = $user_name;
    }


    public function change_password($new_password){
        $this->password = $new_password;

    }
}