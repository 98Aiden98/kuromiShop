import { getUserDataByToken } from './script.js';
import { validateToken } from './script.js';
import { refreshToken } from './script.js';

function updateUserPhoto(request){
    var $form = $(this).closest("form");
    var $inputs = $form.find("input, select, button, textarea");
    var formData = new FormData($form[0]);
    formData.append("token", localStorage.getItem('jwt'));

    $inputs.prop("disabled", true);

    request = $.ajax({
        url: "getUserPhoto.php",
        type: "post",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false
    });

    request.done(function (response, textStatus, jqXHR){
        if (response.status === 'success') {
            $(".account-userphoto-img").attr("src", response.path);
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
}

var request;
var isValidToken = await validateToken(localStorage.getItem('jwt'));
if(isValidToken){
updateUserPhoto(request);
var userData = await getUserDataByToken(localStorage.getItem('jwt'));
$(".account-username-text").text(userData.FirstName + " " + userData.LastName);
} else{
    console.log("Invalid JWT");
}


$(".account-upload-userphoto-form").on("change", async function(event){
    var isValidToken = await validateToken(localStorage.getItem('jwt'));
    if(isValidToken){
        event.preventDefault();
                
        if (request) {
            request.abort();
        }
        
        var $form = $(this).closest("form");
        var $inputs = $form.find("input, select, button, textarea");
        var formData = new FormData($form[0]);
        formData.append("token", localStorage.getItem('jwt'));

        $inputs.prop("disabled", true);

        request = $.ajax({
            url: "upload.php",
            type: "post",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false
        });

        request.done(async function (response, textStatus, jqXHR){
            if (response.status === 'success') {
                console.log(response.message);
                location.reload();
            } else {
                alert("Произошла ошибка при загрузке фотографии.");
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error("The following error occurred: " + textStatus, errorThrown);
            alert("Произошла ошибка при загрузке фотографии.");
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });
    }
});

$(".item-1").on("click", function(){
    window.location.href = "/";
    console.log("1");
});

$(".item-6").on("click", function(){
    localStorage.removeItem("jwt");
    localStorage.removeItem("jwt_refresh");
    window.location.href = "/";
});