// $("#content").css({'color':'red', 
//                    'font-size':'10px',
//                    'margin-left':'15px'});

//$(".wrapper").css("color", "red");

//$("arctile h2").css("color", "red");

//$("article").find("h2").css("color", "red");

//$("h1+p").css("color", "red");

// $("#content").css('height',function(d){
//     return parseFloat(d)*1.2;
// })

// $("#content").addClass('name');

// $("#content").removeClass('box');

//$("#content").toggle();

// var altText = $('img').attr('alt');
// $('img').attr('scr', '/img/default.jpg');

// $('.anim').click(function(){
//     $(this).fadeTo('slow',0.1);
// })
document.addEventListener('DOMContentLoaded', (event) => {
    function refreshToken() {
        const jwt = localStorage.getItem('jwt');
        const refreshJwt = localStorage.getItem('refresh_jwt');

        if (jwt && refreshJwt) {
            $.ajax({
                url: "refresh.php",
                type: "post",
                data: { refresh_token: refreshJwt },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        localStorage.setItem('jwt', response.jwt);
                        localStorage.setItem('refresh_jwt', response.refresh_jwt);
                        console.log("Token refreshed");
                    } else {
                        console.error("Refresh token failed: " + response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON) {
                        console.error("The following error occurred: " + jqXHR.responseJSON.message);
                    } else {
                        console.error("The following error occurred: " + textStatus, errorThrown);
                    }
                }
            });
        }
    }

    // Выполняем JWT проверку и обновление
    const jwt = localStorage.getItem('jwt');
    if (jwt) {
        const parsedJWT = JSON.parse(atob(jwt.split('.')[1]));
        const current_time = Date.now() / 1000;

        if (parsedJWT.exp < current_time) {
            refreshToken();
        } else {
            console.log("Token is still valid");
            validateToken();
        }
    }

    function validateToken() {
        const jwt = localStorage.getItem('jwt');
        if (jwt) {
            $.ajax({
                url: "validate_token.php",
                type: "POST",
                data: { token: jwt },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        console.log("Token is valid");
                        $(".login-logbtn").toggleClass('visibilityHidden');
                        $(".login-regbtn").toggleClass('visibilityHidden');
                        $(".login-active-user").toggleClass('visibilityHidden');
                        $(".login-active-user").text(response.userName + ", здравствуйте!");
                    } else {
                        console.error("Token is invalid: " + response.message);
                        refreshToken();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("The following error occurred: " + textStatus, errorThrown);
                }
            });
        } else {
            console.log("No token found");
            // Здесь можно выполнить действия для перенаправления пользователя на страницу входа
        }
    }


    const slider = document.querySelector('.slider');
    const card = document.querySelector('.card');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let cardWidth = getComputedStyle(slider).width;

    let scrollAmount = 0;

    function scrollSlider() {
        if(scrollAmount >= slider.scrollWidth - slider.clientWidth) {
            scrollAmount = 0;
        } else {
            scrollAmount += slider.clientWidth;
        }
        slider.scrollTo({
            top: 0,
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    setInterval(scrollSlider, 5000);

    prevBtn.addEventListener('click', () => {
        slider.scrollTo({
            top: 0,
            left: (scrollAmount -= slider.clientWidth),
            behavior: 'smooth'
        });
        console.log("prevBtn clicked");
        if(scrollAmount < 0) {
            scrollAmount = 0;
        }
    });

    nextBtn.addEventListener('click', () => {
        if(scrollAmount >= slider.scrollWidth - slider.clientWidth) {
            scrollAmount = 0;
        } else {
            scrollAmount += slider.clientWidth;
        }
        slider.scrollTo({
            top: 0,
            left: scrollAmount,
            behavior: 'smooth'
        });
    });

    const header = document.querySelector('.header');

    window.addEventListener('scroll', () => {
    if (scrollY > 0) {
        header.classList.add('header_active');
    } else {
        header.classList.remove('header_active');
    }
    });

    $(document).ready(function(){
        $('.login-regbtn').click(function(){
          $('.modal-box').toggleClass("show-modal");
        });
        $('.fa-times').click(function(){
          $('.modal-box').toggleClass("show-modal");
          $(".registration-form").removeClass("visibilityHidden");
          $(".success-registration").addClass("visibilityHidden");
          $(".fail-registration").addClass("visibilityHidden");
        });
        $('.login-logbtn').click(function(){
            $('.login-modal-box').toggleClass("show-modal");
        });
        $('.login-fa-times').click(function(){
            $('.login-modal-box').toggleClass("show-modal");
          });
      });

    var request;
    
        $("#login-form").submit(function(event){
            event.preventDefault();
            
            if (request) {
                request.abort();
            }
    
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
    
            $inputs.prop("disabled", true);
    
            request = $.ajax({
                url: "authorization.php",
                type: "post",
                data: serializedData,
                dataType: "json"
            });
    
            request.done(function (response, textStatus, jqXHR){
                if (response.status === 'success') {
                    localStorage.setItem('jwt', response.jwt);
                    localStorage.setItem('refresh_jwt', response.refresh_jwt);
                    console.log("Login successful and JWT saved to localStorage.");
                } else {
                    console.error("Login failed: " + response.message);
                }
            });
    
            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error("The following error occurred: " + textStatus, errorThrown);
            });
    
            request.always(function () {
                $inputs.prop("disabled", false);
            });
        });

    $("#registration").submit(function(event){

        event.preventDefault();

        if (request) {
            request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "registration.php",
            type: "post",
            data: serializedData,
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR){
            if (response.status === 'success') {
                console.log("Hooray, it worked!");
                console.log(response.message);
                $(".registration-form").addClass("visibilityHidden");
                $(".success-registration").removeClass("visibilityHidden");
            } else {
                console.error("The following error occurred: " + response.message);
                $(".registration-form").addClass("visibilityHidden");
                    $(".fail-registration").removeClass("visibilityHidden");
                setTimeout(function() {
                    $(".registration-form").removeClass("visibilityHidden");
                    $(".fail-registration").addClass("visibilityHidden");
                }, 3000);
                $(".fail-registration-text-desc").text(response.message);
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });

    });
});

