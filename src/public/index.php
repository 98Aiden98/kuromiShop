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

    <div class="center modal-box">

    <div class="fas fa-times"><img class="fa-times-img" src="img/cross-circle-purple.png" alt=""></div>

<div class="form_container">

    <div class="success-registration center visibilityHidden">
        <img class="success-registration-img" src="img/check-mark-purple.png" alt="">
        <p class="success-registration-text">Вы успешно зарегистрированы!</p>
    </div>

    <div class="fail-registration center visibilityHidden">
        <img class="fail-registration-img" src="img/cross-circle-red.png" alt="">
        <p class="fail-registration-text">Ошибка при регистрации!</p>
        <p class="fail-registration-text-desc"></p>
    </div>

  <form class="registration-form"  action="registration.php" name="registration" id="registration" method="post">
    <div class="form_wrap form_grp">
        <div class="form_item">
            <label>Имя</label>
            <input type="text" id="first_name" name="first_name" required >

        </div>
        <div class="form_item">
            <label>Фамилия</label>
            <input type="text" id="last_name" name="last_name" required>

        </div>
    </div>
    <div class="form_wrap">
        <div class="form_item">
            <label>Почта</label>
            <input type="text" id="email" name="email" required>

        </div>
    </div>
    <div class="form_wrap form_grp">
        <div class="form_item">
            <label>Пароль</label>
            <input type="password" id="pass" name="pass" required>

        </div>
        <div class="form_item">
            <label>Подтверждение пароля</label>
            <input type="password" id="pass2" name="pass2" required>

        </div>
    </div>
    <div class="form_wrap">
        <div class="form_item">
            <label>Пол</label>
            <select id="gender" name="gender">
                <option value="Мужской">Мужской</option>
                <option value="Женский">Женский</option>
            </select>
        </div>
    </div>
    <div class="form_wrap">
        <div class="form_item">
            <label>Телефон</label>
            <input type="text" id="phone" name="phone" required>
            <div class="error" id="phone"></div>
        </div>
    </div>
    <div class="btn">
      <input type="submit" value="Зарегистрироваться">
    </div>
  </form>
</div>
</div>

    <div class="main">
    <button class="slider-button prev-btn">&#10094;</button>
        <div class="slider">
            <div class="card card1"></div>
            <div class="card card2"></div>
            <div class="card card3"></div>
        </div>
        <button class="slider-button next-btn">&#10095;</button>
    </div>

    <div class="lastProduct">
        <div class="lastProduct-text">

        </div>

        <div class="lastProduct-photo">

        </div>
    </div>

    

    <footer></footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>