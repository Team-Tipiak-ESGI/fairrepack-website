const UserController = {};

UserController.signup = function(form) {
    if (form === undefined)
        form = document.querySelector('form#accountForm');

    if (!form.checkValidity()) return false;

    UserModel.signup(form)
        .then(token => {
            alert("You are signed up!");
            userVue.updateAccountPage();
            renewToken();
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
            form.elements["email"].classList.remove("is-invalid");
            form.elements["password"].classList.remove("is-invalid");
            form.elements["email"].classList.add("is-valid");
            form.elements["password"].classList.add("is-valid");

            const uuid = getToken()?.payload.uuid;
            if (uuid !== undefined) {
                userVue.buildProductDiv(document.querySelector("div#userProducts"), uuid);
                userVue.updateAccountPage();
            }
            renewToken();
        })
        .catch(res => {
            form.elements["email"].classList.add("is-invalid");
            form.elements["password"].classList.add("is-invalid");
        });
}

UserController.logout = function() {
    // Token is invalid, silent sign out
    if (getToken().valid) {
        alert("You are logged out!");
    }

    window.localStorage.removeItem('token');
    userVue.updateAccountPage();
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