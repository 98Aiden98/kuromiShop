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

$refresh_token = $_POST['refresh_token'];
$secret_key = "12345";
try {
    $decoded = JWT::decode($refresh_token, new Key($secret_key, 'HS256'));
    $email = $decoded->data->email;

    $checkEmailQuery = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $connect->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $response = [
            'status' => 'error',
            'message' => 'Пользователя с такой почтой не существует',
        ];
        echo json_encode($response);
        exit();
    }

    $new_issuedat_claim = time();
    $new_expire_claim = $new_issuedat_claim + (60); // 1 час

    $new_token = array(
        "iss" => "localhost",
        "aud" => "localhost",
        "iat" => $new_issuedat_claim,
        "exp" => $new_expire_claim,
        "data" => array(
            "email" => $email
        ),
    );

    $jwt = JWT::encode($new_token, $secret_key, 'HS256');

    $refresh_token_claim = $new_issuedat_claim + (60*60*2); // 2 часа

        $refresh_token = array(
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => $new_issuedat_claim,
            "exp" => $refresh_token_claim,
            "data" => array(
                "email" => $email
            )
        );

        $refresh_jwt = JWT::encode($refresh_token, $secret_key, 'HS256');

        $response = [
            'status' => 'success',
            'jwt' => $jwt,
            'refresh_jwt' => $refresh_jwt,
            'expireAt' => $expire_claim
        ];
    echo json_encode($response);
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Недопустимый refresh token: ' . $e->getMessage()
    ];
    echo json_encode($response);
}
?>
