const UserModel = {};

/**
 * Create an account
 * @param {HTMLFormElement} form
 * @returns Promise<string> Returns UUIDv4
 */
UserModel.signup = function(form) {
    return new Promise((resolve, reject) => {
        fetch('/api/user/create.php', {
            method: 'POST',
            body: formDataToJSON(new FormData(form)),
        })
            .then(res => {
                if (200 <= res.status && res.status < 300) {
                    return res.json();
                } else {
                    throw res;
                }
            })
            .then(json => {
                window.localStorage.setItem('token', json.token);
                resolve(json.token);
            })
            .catch((e) => {
                reject(e);
            });
    });
}

/**
 * Login to your account
 * @param {HTMLFormElement} form
 * @returns Promise<string> Returns token
 */
UserModel.login = function(form) {
    return new Promise((resolve, reject) => {
        fetch('/api/user/login.php', {
            method: 'POST',
            body: formDataToJSON(new FormData(form)),
        })
            .then(res => {
                if (200 <= res.status && res.status < 300) {
                    return res.json();
                } else {
                    throw res;
                }
            })
            .then(json => {
                if (json.token) {
                    window.localStorage.setItem('token', json.token);
                    resolve(json.token);
                }
            })
            .catch((e) => {
                reject(e);
            });
    });
}

/**
 * Remove your account
 * @returns Promise<*>
 */
UserModel.remove = function() {
    return new Promise((resolve, reject) => {

    });
}

/**
 * Update your profile
 * @param {HTMLFormElement} form
 * @returns Promise<*>
 */
UserModel.update = function(form) {
    return new Promise((resolve, reject) => {

    });
}

/**
 * Logout from your account
 * @returns Promise<*>
 */
UserModel.logout = function() {
    return new Promise((resolve, reject) => {
        window.localStorage.removeItem('token');
        resolve();
    });
}