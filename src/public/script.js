export async function refreshToken(jwt) {
    const refreshJwt = localStorage.getItem('refresh_jwt');

    if (jwt && refreshJwt) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "refresh.php",
                type: "post",
                data: { refresh_token: refreshJwt },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        localStorage.setItem('jwt', response.jwt);
                        localStorage.setItem('refresh_jwt', response.refresh_jwt);
                        console.log("JWT refreshed");
                        resolve();
                    } else {
                        console.error("Refresh JWT failed: " + response.message);
                        localStorage.removeItem('jwt');
                        localStorage.removeItem('refresh_jwt');
                        location.reload();
                        reject(new Error(response.message));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON) {
                        console.error("The following error occurred: " + jqXHR.responseJSON.message);
                        reject(new Error(jqXHR.responseJSON.message));
                    } else {
                        console.error("The following error occurred: " + textStatus, errorThrown);
                        reject(new Error(textStatus));
                    }
                }
            });
        });
    }
}

export async function validateToken(jwt){
    if (jwt) {
        const parsedJWT = JSON.parse(atob(jwt.split('.')[1]));
        const current_time = Date.now() / 1000;

        if (parsedJWT.exp < current_time) {
            console.log(parsedJWT.exp + " parse seconds");
            console.log(current_time + " current seconds");
            await refreshToken(jwt);
            return true;
        } else {
            console.log("JWT is still active");
            return true;
        }
    } else {
        console.log("No JWT found");
        return false;
    }
}

export async function getUserDataByToken(jwt) {
    if(jwt){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "get_user_data_by_token.php",
                type: "POST",
                data: { token: jwt },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        var userDataSet = response.userData;
                        resolve(userDataSet);
                    } else {
                        console.error("JWT is invalid: " + response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("The following error occurred: " + textStatus, errorThrown);
                    reject(new Error(textStatus));
                }
            });
        });
    } else {
        console.log("No JWT found");
        return null;
    }
}



document.addEventListener('DOMContentLoaded', (event) => {
    var windowLoc = $(location).attr('pathname');
    const jwt = localStorage.getItem('jwt');
    switch (windowLoc) {

        case "/":
            var infoJS = document.createElement('script');
            infoJS.type = 'module';
            infoJS.src = 'index.js';
            $('body').append(infoJS);
        break;

        case "/account.php":
            var infoJS = document.createElement('script');
            infoJS.type = 'module';
            infoJS.src = 'account.js';
            $('body').append(infoJS);
        break;

    }


});

