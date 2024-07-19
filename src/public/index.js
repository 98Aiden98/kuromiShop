
    import { getUserDataByToken } from './script.js';
    import { validateToken } from './script.js';
    import { refreshToken } from './script.js';

    async function setLoginStyle(isValidToken){
        if(isValidToken){
            var userData = await getUserDataByToken(localStorage.getItem('jwt'));
            $(".login-active-user").toggleClass('visibilityHidden');
            $(".login-active-user-text").text(userData.FirstName);
        } else{
            $(".login-logbtn").toggleClass('visibilityHidden');
            $(".login-regbtn").toggleClass('visibilityHidden');
        }
    }
    
    var isValidToken = await validateToken(localStorage.getItem('jwt'));
    await setLoginStyle(isValidToken);
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
    
            request.done(async function (response, textStatus, jqXHR){
                if (response.status === 'success') {
                    localStorage.setItem('jwt', response.jwt);
                    localStorage.setItem('refresh_jwt', response.refresh_jwt);
                    console.log("Login successful and JWT saved to localStorage.");
                    setTimeout(function() {
                        $(".login-modal-box").removeClass("show-modal");
                    }, 300);
                    location.reload();
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
                console.log("Register successfully!");
                console.log(response.message);
                $(".registration-form").addClass("visibilityHidden");
                $(".success-registration").removeClass("visibilityHidden");
                setTimeout(function() {
                    $(".success-registration").addClass("visibilityHidden");
                }, 2000);
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

    $(".login-active-user").on("click", function(){
        window.location.href = "account.php";
    });