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

$secret_key = "12345";

$token = $_POST['token'];

if($token != null){
    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        $email = $decoded->data->email;

        $checkEmailQuery = "SELECT * FROM Users WHERE Email = ?";
        $stmt = $connect->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $dataResult = $result->fetch_assoc();
        $response = [
            'status' => 'success',
            'message' => 'Token is valid',
            'data' => $decoded->data,
            'userData' => $dataResult
        ];
        echo json_encode($response);
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid token: ' . $e->getMessage()
        ];
        echo json_encode($response);
    }
}
?>