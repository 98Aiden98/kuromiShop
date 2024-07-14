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
        if(scrollAmount <= slider.scrollWidth - slider.clientWidth) {
            slider.scrollTo({
                top: 0,
                left: (scrollAmount += slider.clientWidth),
                behavior: 'smooth'
            });
            console.log("nextBtn clicked");
        }
    });
});

