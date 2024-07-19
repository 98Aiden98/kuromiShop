<?php
$DEFAULT_USERPHOTO_PATH = "/img/default.png";

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$connect = mysqli_connect($_ENV["MYSQL_HOST"],$_ENV["MYSQL_USER"],$_ENV["MYSQL_PASSWORD"],"kuromi_shop");
if (mysqli_connect_errno()) {
    $response['status'] = 'error';
        $response['message'] = 'Connection failed: ' . $connect->connect_error;
        echo json_encode($response);
        exit();
}
mysqli_query($connect, "SET NAMES utf8");

if ($connect->connect_error) {
    die("Ошибка подключения: " . $connect->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $password = $_POST['pass'];
    $passwordVerify = $_POST['pass2'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];

    if ($password != $passwordVerify) {
        $response['status'] = 'error';
        $response['message'] = 'Пароли не совпадают';
        echo json_encode($response);
        exit();
    }

    $checkEmailQuery = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $connect->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Пользователь с такой почтой уже существует';
        echo json_encode($response);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Подготовка SQL-запроса для вставки данных в таблицу users
    $sql = "INSERT INTO Users (FirstName, LastName, Email, Password, Gender, Phone) VALUES (?, ?, ?, ?, ?, ?)";

    // Подготовка выражения
    $stmt = $connect->prepare($sql);

    // Привязка параметров
    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $gender, $phone);

    
    // Добавление записи
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'New record created successfully';

        $last_id = $connect->insert_id;

        $sqlUserPhoto = "INSERT INTO UserPhoto (UserID, path) VALUES (?, ?)"; // Добавление записи в таблицу с фотографиями
        $stmtUserPhoto = $connect->prepare($sqlUserPhoto);
        $stmtUserPhoto->bind_param("is", $last_id, $DEFAULT_USERPHOTO_PATH);
        $stmtUserPhoto->execute();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $sql . '<br>' . $conn->error;
    }

    // Закрытие выражения и подключения
    $stmt->close();
    $connect->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}
echo json_encode($response);
?>