<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$connect = mysqli_connect($_ENV["MYSQL_HOST"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], "kuromi_shop");
if (mysqli_connect_errno()) {
    $response = [
        'status' => 'error',
        'message' => 'Connection failed: ' . $connect->connect_error
    ];
    echo json_encode($response);
    exit();
}
mysqli_query($connect, "SET NAMES utf8");

$token = $_POST['token'];
$secret_key = "12345";

$decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
$email = $decoded->data->email;

$checkIdQuery = "SELECT UserID FROM Users WHERE Email = ?";
$stmt = $connect->prepare($checkIdQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userId = $row['UserID'];

$checkIdQuery = "SELECT path FROM UserPhoto WHERE UserID = ?";
$stmt = $connect->prepare($checkIdQuery);
$stmt->bind_param("i", $userId);

if($stmt->execute()){
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $response['status'] = 'success';
    $response['message'] = 'User photo uploaded successfully';
    $response['path'] = $row['path'];
    echo json_encode($response);
} else {
    $response['status'] = 'fail';
    $response['message'] = 'Failed while getting user photo';
    echo json_encode($response);
}
?>