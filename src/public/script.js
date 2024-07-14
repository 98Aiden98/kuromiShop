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
          $('.login-regbtn').toggleClass("show-modal");
        });
        $('.fa-times').click(function(){
          $('.modal-box').toggleClass("show-modal");
          $('.login-regbtn').toggleClass("show-modal");
          $(".registration-form").removeClass("visibilityHidden");
          $(".success-registration").addClass("visibilityHidden");
          $(".fail-registration").addClass("visibilityHidden");
        });
      });

    var request;

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

