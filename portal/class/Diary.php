<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-12
 * Time: 16:40
 */

class Diary
{
    var $id;
    var $content;
    var $create_data;
    var $modify_date;
    var $category;

    public function __construct($content)
    {
        $this->content = $content;
        $this->create_data = date('Y-m-d H:i:s');
    }

    public function update_diary(){

    }
}
