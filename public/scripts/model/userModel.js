const UserModel = {};

/**
 * Create an account
 * @param {HTMLFormElement} form
 * @returns Promise<string> Returns UUIDv4
 */
UserModel.signup = function(form) {
    return new Promise(async (resolve, reject) => {
        fetch('/api/user/create.php', {
            method: 'POST',
            body: await formDataToJSON(new FormData(form)),
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
    return new Promise(async (resolve, reject) => {
        fetch('/api/user/login.php', {
            method: 'POST',
            body: await formDataToJSON(new FormData(form)),
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
