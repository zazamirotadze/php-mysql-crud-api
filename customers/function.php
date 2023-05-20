<?php
require "../inc/dbcon.php";

function error422($message)
{
    $data = [
        "status" => 500,
        "message" => $message,
    ];
    header("{$_SERVER['SERVER_PROTOCOL']} unprocessable entity");
    return json_encode($data);
    exit();
}
function storeCustomer($customerInput)
{
    global $con;
    $name = mysqli_real_escape_string($con, $customerInput["name"]);
    $email = mysqli_real_escape_string($con, $customerInput["email"]);
    $phone = mysqli_real_escape_string($con, $customerInput["phone"]);
    if (empty(trim($name))) {
        return error422("enter your name");
    } elseif (empty(trim($email))) {
        return error422("enter your email");
    } elseif (empty(trim($phone))) {
        return error422("enter your phone");
    } else {
        $query = "insert into customers (name, email, phone) values('$name', '$email', '$phone')";
        $result = mysqli_query($con, $query);
        if ($result) {
            $data = [
                "status" => 201,
                "message" => "customer created succesfully",
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 201 customer created succesfully");
            return json_encode($data);
        } else {
            $data = [
                "status" => 500,
                "message" => "internal server error",
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 500 internal server error");
            return json_encode($data);
        }
    }
}
function customerList()
{
    global $con;
    $query = "select * from customers";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                "status" => 200,
                "message" => "customer list fetched successfully",
                "data" => $res
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 200 ok");
            return json_encode($data);
        } else {
            $data = [
                "status" => 404,
                "message" => "no customer found",

            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 404 no customer found");
            return json_encode($data);
        }
    } else {
        $data = [
            "status" => 500,
            "message" => "internal server error",
        ];
        header("{$_SERVER['SERVER_PROTOCOL']} 500 internal server error");
        return json_encode($data);
    }
}
function getCustomer($customerParams)
{
    global $con;
    if ($customerParams["id"] == null) {
        return error422("enter your customer id");
    }

    $customerId = mysqli_real_escape_string($con, $customerParams["id"]);
    $query = "select * from customers where id='$customerId' limit 1";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                "status" => 200,
                "message" => "customer fetched Successfully",
                "data" => $res
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 200 ok");
            return json_encode($data);
        } else {
            $data = [
                "status" => 404,
                "message" => "no customer found",
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 404 not found");
            return json_encode($data);
        }
    } else {
        $data = [
            "status" => 500,
            "message" => "internal server error",
        ];
        header("{$_SERVER['SERVER_PROTOCOL']} 500 internal server error");
        return json_encode($data);
    }
}
function updateCustomer($customerInput, $customerParams)
{
    global $con;
    if (!isset($customerParams["id"])) {
        return error422("customer id not found in url");
    } elseif ($customerParams["id"] == null) {
        return error422("enter the customer id");
    }
    $customerId = mysqli_real_escape_string($con, $customerParams["id"]);
    $name = mysqli_real_escape_string($con, $customerInput["name"]);
    $email = mysqli_real_escape_string($con, $customerInput["email"]);
    $phone = mysqli_real_escape_string($con, $customerInput["phone"]);
    if (empty(trim($name))) {
        return error422("enter your name");
    } elseif (empty(trim($email))) {
        return error422("enter your email");
    } elseif (empty(trim($phone))) {
        return error422("enter your phone");
    } else {
        $query = "update customers set name='$name', email='$email', phone='$phone' where id='$customerId' limit 1";
        $result = mysqli_query($con, $query);
        if ($result) {
            $data = [
                "status" => 200,
                "message" => "customer updated succesfully",
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 200 Success");
            return json_encode($data);
        } else {
            $data = [
                "status" => 500,
                "message" => "internal server error",
            ];
            header("{$_SERVER['SERVER_PROTOCOL']} 500 internal server error");
            return json_encode($data);
        }
    }
}

function deleteCustomer($customerParams)
{
    global $con;
    if (!isset($customerParams["id"])) {
        return error422("customer id not found in url");
    } elseif ($customerParams["id"] == null) {
        return error422("enter the customer id");
    }
    $customerId = mysqli_real_escape_string($con, $customerParams["id"]);
    $query = "delete from customers where id=$customerId limit 1";
    $result = mysqli_query($con, $query);
    if ($result) {
        $data = [
            "status" => 200,
            "message" => "customer deleted successfully",
        ];
        header("{$_SERVER['SERVER_PROTOCOL']} 204 deleted");
        return json_encode($data);
    } else {
        $data = [
            "status" => 404,
            "message" => "customer not found",
        ];
        header("{$_SERVER['SERVER_PROTOCOL']} 404 not found");
        return json_encode($data);
    }
}
