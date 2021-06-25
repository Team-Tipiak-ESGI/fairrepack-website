const UserController = {};

/**
 * Make a request to the API to create a new user with the information from the form
 * @param {HTMLFormElement} form
 * @returns {boolean} User has been created
 */
UserController.signup = function(form) {
    if (form === undefined)
        form = document.querySelector('form#accountForm');

    // Validate form
    if (!form.checkValidity()) return false;

    UserModel.signup(form)
        .then(token => {
            alert("You are signed up!");
            userVue.updateAccountPage(); // Update account page information
            renewToken();
        })
        .catch(res => {
            // Error handling
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

/**
 * Make a request to the API to get the JWT used to make authenticated requests
 * @param {HTMLFormElement} form
 * @returns {boolean} User has been authenticated
 */
UserController.login = function(form) {
    if (form === undefined)
        form = document.querySelector('form#accountForm');

    // Check form validity
    if (!form.checkValidity()) return false;

    UserModel.login(form)
        .then(token => {
            form.elements["email"].classList.remove("is-invalid");
            form.elements["password"].classList.remove("is-invalid");
            form.elements["email"].classList.add("is-valid");
            form.elements["password"].classList.add("is-valid");

            const uuid = getToken()?.payload.uuid;
            if (uuid !== undefined) {
                // Build the list of product the user has
                userVue.buildProductDiv(document.querySelector("div#userProducts"), uuid);
                userVue.updateAccountPage(); // Update account page information
            }
            renewToken();
        })
        .catch(res => {
            // Error handling
            form.elements["email"].classList.add("is-invalid");
            form.elements["password"].classList.add("is-invalid");
        });
}

/**
 * Removes the token from the browser's local storage
 */
UserController.logout = function() {
    // Token is invalid, silent sign out
    if (getToken().valid) {
        alert("You are logged out!");
    }

    window.localStorage.removeItem('token'); // Remove the token
    userVue.updateAccountPage();
    updateHeaderAccount(); // Update website's navbar
}

/**
 * Makes a request to the API to delete the user
 */
UserController.remove = function() {
    authenticatedFetch("/api/user/delete.php", "DELETE")
        .then(() => {
            alert("Account deleted!");
        })
        .catch((res) => {
            // Error handling
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

/**
 * Makes a request to the API to update user's information
 * @param {HTMLFormElement} form Form containing user and address information
 * @returns {Promise<void>}
 */
UserController.update = async function(form) {
    authenticatedFetch(`/api/user/update.php`, "POST", await formDataToJSON(new FormData(form)))
}
