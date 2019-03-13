<?php

require "class/ResponseSuccess.php";

switch ($_GET['type']){
    case "query": break;
    case "update": break;
    default:
        $response = json_encode(new ResponseError());
        echo $response;
}

