<?php
error_reporting(0);
include("../inc/headers.php");
header('Access-Control-Allow-Methods: PUT');
include("function.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    // Handle preflight request
    http_response_code(204); // Set HTTP status to 204 (No Content)
    exit();
}
if ($requestMethod === "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    $updateCustomer = updateCustomer($inputData, $_GET);

    echo $updateCustomer;
} else {
    $data = [
        "status" => 405,
        "message" => "{$requestMethod} method not allowed",
    ];
    header("{$_SERVER['SERVER_PROTOCOL']} 405 method not allowed");
    echo json_encode($data);
}
