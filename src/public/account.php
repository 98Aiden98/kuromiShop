<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"/>
  <title>Личный кабинет</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Anonymous+Pro" />
</head>
<body class="account-body">
    
    <div class="account-main-block">
        <div class="account-left-menu">

            <div class="account-userinfo">

                <div class="account-userphoto">
                    <form class="account-userphoto-form" action="upload.php" method="post" enctype="multipart/form-data">
                        <label class="account-upload-userphoto-form">
                        <input type="file" name="myFile">
                        <img src="img/default.png" alt="" class="account-userphoto-img">
                        </label>
                    </form>
                </div>

                <div class="account-username">
                    <span class="account-username-text"></span>
                </div>
        
            </div>

            <div class="account-menu">
                <ul class="account-menu-list">
                    <li class="account-menu-item item-1">
                        <div class="account-menu-item-img-container">
                            <img src="img/home.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">На главную</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                    <li class="account-menu-item item-2">
                        <div class="account-menu-item-img-container">
                            <img src="img/account-info.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">Личные данные</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                    <li class="account-menu-item item-3">
                        <div class="account-menu-item-img-container">
                            <img src="img/shopping-cart.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">История покупок</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                    <li class="account-menu-item item-4">
                        <div class="account-menu-item-img-container">
                            <img src="img/star.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">Избранное</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                    <li class="account-menu-item item-5">
                        <div class="account-menu-item-img-container">
                            <img src="img/truck-sell.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">Оплата и доставка</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                    <li class="account-menu-item item-6">
                        <div class="account-menu-item-img-container">
                            <img src="img/exit.svg" alt="" class="account-menu-item-img">
                        </div>
                        <span class="account-menu-link">Выйти</span>
                        <div class="account-menu-arrowright">
                            <img src="img/arrow-right.svg" alt="" class="arrow-right">
                        </div>
                    </li>
                </ul>
            </div>

        </div>

        <div class="account-content">

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="module" src="script.js"></script>
</body>
</html>