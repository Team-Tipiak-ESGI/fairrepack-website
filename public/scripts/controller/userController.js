const UserController = {};

UserController.signup = function(form) {
    if (form === undefined)
        form = document.querySelector('form#accountForm');

    if (!form.checkValidity()) return false;

    UserModel.signup(form)
        .then(token => {
            alert("You are signed up!");
        })
        .catch(res => {
            switch (res.status) {
                case 409:
                    alert("User already exists.");
                    break;
                case 400:
                    alert("Bad request.");
                    break;
                default:
                    alert("Something went wrong :/");
                    break;
            }
        });
}

UserController.login = function(form) {
    if (form === undefined)
        form = document.querySelector('form#accountForm');

    if (!form.checkValidity()) return false;

    UserModel.login(form)
        .then(token => {
            alert("You are logged in!");
            const uuid = getToken()?.payload.uuid;
            if (uuid !== undefined)
                userVue.buildProductDiv(document.querySelector("div#userProducts"), uuid);
        })
        .catch(res => {
            switch (res.status) {
                case 404:
                    alert("User does not exists.");
                    break;
                case 400:
                    alert("Bad request.");
                    break;
                default:
                    alert("Something went wrong :/");
                    break;
            }
        });
}

UserController.logout = function() {
    const token = window.localStorage.getItem('token');
    if (token === null) {
        alert("You are not logged in!");
        return;
    }

    UserModel.logout().then(() => {
        alert("You are logged out!");
    });
}

UserController.remove = function() {
    authenticatedFetch("/api/user/delete.php", "DELETE")
        .then(() => {
            alert("Account deleted!");
        })
        .catch((res) => {
            switch (res.status) {
                case 400:
                    alert("Bad request.");
                    break;
                default:
                    alert("Something went wrong :/");
                    break;
            }
        });
}