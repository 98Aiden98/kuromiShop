<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if ($_FILES['myFile']['error'] !== UPLOAD_ERR_OK) {
    switch ($_FILES['myFile']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $message = "File too large.";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "File upload was not completed.";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "No file was uploaded.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Missing a temporary folder.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Failed to write file to disk.";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "File upload stopped by a PHP extension.";
            break;
        default:
            $message = "Unknown upload error.";
            break;
    }

    $response = [
        'status' => 'error',
        'message' => $message
    ];
    echo json_encode($response);
    exit();
}

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

    $file = $_FILES['myFile'];
    $token = $_POST['token'];
    $secret_key = "12345";

    $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
    $email = $decoded->data->email;

    $checkEmailQuery = "SELECT UserID FROM Users WHERE Email = ?";
    $stmt = $connect->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userId = $row['UserID'];

    // Получаем наше изображение, имя которого мы указали в атрибуте `name="file"`

    $path =  __DIR__ . '/uploads/'; // Наш путь до папки загрузок

    $fileExt = end(explode('.', $file['name']));  // Получили расширение файла `jpg`

    $fileName = uniqid('image_') . "." . $fileExt;// Сгенерировали уникальное имя нашему файлу, с расширением
    $filePath = 'uploads/'.$fileName;
    try {
        
        $sqlQueryDeleteLastPhoto = 'SELECT path from UserPhoto WHERE UserID = ?';

        $stmtDeleteLastPhoto = $connect->prepare($sqlQueryDeleteLastPhoto);

        $stmtDeleteLastPhoto->bind_param('i', $userId);

        $stmtDeleteLastPhoto->execute();

        $resultDeleteLastPhoto = $stmtDeleteLastPhoto->get_result();
        $assocLastPhoto = $resultDeleteLastPhoto->fetch_assoc();
        $LastPhotoPath = $assocLastPhoto['path'];

        if($LastPhotoPath !== "img/default.png"){
            unlink($LastPhotoPath);  // Удаляем старое изображение, если оно есть.
        }

        $sql = 'UPDATE UserPhoto SET path = ? WHERE UserID = ?';   // Создаем SQL-запрос для вставки имени изображения

        $stmt = $connect->prepare($sql);    // Подготавливаем наш запрос

        $stmt->bind_param("si", $filePath, $userId);

        if($stmt->execute()){
            move_uploaded_file($file['tmp_name'], $filePath);
            $response['status'] = 'success';
            $response['message'] = 'Image uploaded successfully';
            $response['path'] = $path.$fileName;
            echo json_encode($response);
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Failed while uploading image';
            echo json_encode($response);
        }
        
    } catch (Exception $e) {

        echo $e->getMessage();

    }
