<?php
error_reporting(0);
include("../inc/headers.php");
header('Access-Control-Allow-Methods: POST');
include("function.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    // Handle preflight request
    http_response_code(204); // Set HTTP status to 204 (No Content)
    exit();
}
if ($requestMethod === "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $storeCustomer = storeCustomer($_POST);
    } else {
        $storeCustomer = storeCustomer($inputData);
    }
    echo $storeCustomer;
} else {
    $data = [
        "status" => 405,
        "message" => "{$requestMethod} method not allowed",
    ];
    header("{$_SERVER['SERVER_PROTOCOL']} 405 method not allowed");
    echo json_encode($data);
}
