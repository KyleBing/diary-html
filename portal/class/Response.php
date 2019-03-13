<?php
/**
 * Created by PhpStorm.
 * User: Kyle
 * Date: 2019-03-13
 * Time: 17:02
 */


class Response
{
    var $success;
    var $info;

    public function __construct(string $info)
    {
        $this->info = $info;
    }


    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success): void
    {
        $this->success = $success;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info): void
    {
        $this->info = $info;
    }
}

class ResponseError extends Response
{
    var $success = false;
    var $info   = '';

    public function __construct(string $info = '请求失败')
    {
        $this->info = $info;
    }


}

class ResponseSuccess extends Response
{
    var $data;
    var $success = true;
    var $info = '';

    public function __construct(string $info = '请求成功')
    {
        $this->info = $info;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

}
