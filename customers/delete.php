<?php
include("../inc/headers.php");
header('Access-Control-Allow-Methods: DELETE');
include("function.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod === "DELETE") {
    $deleteCustomer = deleteCustomer($_GET);
    echo $deleteCustomer;
} else {
    $data = [
        "status" => 405,
        "message" => "{$requestMethod} method not allowed",
    ];
    header("{$_SERVER['SERVER_PROTOCOL']} 405 method not allowed");
    echo json_encode($data);
}
