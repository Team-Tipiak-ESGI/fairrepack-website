/**
 * This JavaScript file must be present on every pages
 */

function renewToken() {
    const expiringDate = new Date(getToken().payload.expiry * 1000);
    if (expiringDate <= Date.now()) {
        addNotificationToast("Session expired", "Please <a href='/account.php'>log in</a>.", expiringDate);
        return;
    }

    const renewIn = Math.max(expiringDate - Date.now() - 10000 /* 10 seconds */, 10000);

    console.log("Renewing session in " + renewIn + " seconds");

    setTimeout(() => {
        authenticatedFetch('/api/user/login.php')
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
                    addNotificationToast("Session renewed", "Your session has been renewed.");
                    renewToken();
                }
            })
            .catch((e) => {
                addNotificationToast("Oops", "Your session could not be renewed, please <a href='/account.php'>log in</a> to renew your session.");
            });
    }, renewIn)
}

window.addEventListener("load", renewToken);
window.addEventListener("load", cartVue.updateHeader);

// Bootstrap form validation
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()