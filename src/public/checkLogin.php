<?php
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
$password = $_POST['password'];

global $connect;

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
            return $response;
        }

        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        if (password_verify($password, $hashedPassword)) {
            $response = [
                'status' => 'success',
                'message' => 'Успешная авторизация',
                'user' => [
                    'email' => $row['Email'],
                    'password' => $hashedPassword
                ]
            ];
            return $response;
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Неверный пароль'
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method.'
        ];
        return $response;
    }


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = checkLogin($email, $password);
    echo json_encode($result);
}
?>