<?php
include("../inc/headers.php");
header('Access-Control-Allow-Methods: GET');
include("function.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod === "GET") {
    if (isset($_GET["id"])) {
        $customerId = $_GET["id"];
        $customer = getCustomer($_GET);
        echo $customer;
    } else {
        $customerList = customerList();
        echo $customerList;
    }
} else {
    $data = [
        "status" => 405,
        "message" => "{$requestMethod} method not allowed",
    ];
    header("{$_SERVER['SERVER_PROTOCOL']} 405 method not allowed");
    echo json_encode($data);
}
