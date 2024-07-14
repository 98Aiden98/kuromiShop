<?php
$connect = mysqli_connect($_ENV["MYSQL_HOST"],$_ENV["MYSQL_USER"],$_ENV["MYSQL_PASSWORD"],"kuromi_shop");
if (mysqli_connect_errno()) {
    printf("error: %s\n", mysqli_connect_error());
    exit();
}
mysqli_query($connect, "SET NAMES utf8");
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title></title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Anonymous+Pro" />
</head>
<body>

    <header class="header">
    <img src="img/logo.png" alt="" class="logo">
    <div class="menu">
        <a href="" class="menu-item"><span>Главная</span></a>
        <a href="" class="menu-item"><span>Наши продукты</span></a>
        <a href="" class="menu-item"><span>О нас</span></a>
        <a href="" class="menu-item"><span>Контакты</span></a>
    </div>
    <div class="login">
        <button class="login-logbtn">Войти</button>
        <button class="login-regbtn">Регистрация</button>
    </div>
    </header>

    <div class="main">
    <button class="slider-button prev-btn">&#10094;</button>
        <div class="slider">
            <div class="card card1"></div>
            <div class="card card2"></div>
            <div class="card card3"></div>
        </div>
        <button class="slider-button next-btn">&#10095;</button>
    </div>

    

    <footer></footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>