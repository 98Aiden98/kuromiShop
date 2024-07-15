<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

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

$email = $_POST['email'];
$password = $_POST['pass'];
$secret_key = "12345";

    if ($email != null && $password != null) {
        $checkEmailQuery = "SELECT * FROM Users WHERE Email = ?";
        $stmt = $connect->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $response = [
                'status' => 'error',
                'message' => 'Пользователя с такой почтой не существует'
            ];
            echo json_encode($response);
        }

        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        if (password_verify($password, $hashedPassword)) {
        $issuer_claim = "localhost";
        $audience_claim = "localhost";
        $issuedat_claim = time();
        $expire_claim = $issuedat_claim + (60); // 1 час

        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "email" => $row['Email']
            )
        );
        
        $jwt = JWT::encode($token, $secret_key, 'HS256');

        $refresh_token_claim = $issuedat_claim + (60*60*2); // 2 часа

        $refresh_token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $refresh_token_claim,
            "data" => array(
                "email" => $row['Email']
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

        } else {
            $response = [
                'status' => 'error',
                'message' => 'Неверный пароль'
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method.'
        ];
        echo json_encode($response);
    }
?>