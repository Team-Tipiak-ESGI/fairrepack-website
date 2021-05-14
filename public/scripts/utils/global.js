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

// Search bar
(function () {
    const SEARCH_PAGE = "/references.php";
    document.getElementById("searchForm").addEventListener("submit", (e) => {
        if (window.location.pathname !== SEARCH_PAGE) {
            window.location.href = `${location.origin + SEARCH_PAGE}?search=${e.target.elements["search"].value}`;
        }

        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    if (window.location.pathname === SEARCH_PAGE) {
        let lastUpdate = 0, update, lastValue;
        const searchBar = document.getElementById("searchBar");

        const search = getPage().search;

        if (search) {
            searchBar.value = search;
            document.getElementById("searchName").innerText = `Displaying results for: ${search}`;
        }

        searchBar.addEventListener("keydown", e => lastValue = e.target.value)
        searchBar.addEventListener("keyup", e => {
            const value = e.target.value;
            if (value !== lastValue && window.location.pathname === SEARCH_PAGE) {
                if (update !== undefined) clearTimeout(update);

                let timeout = Date.now() - lastUpdate < 200 ? 200 : 0;

                update = setTimeout(() => {
                    window.history.pushState('', '', `${location.origin + SEARCH_PAGE}?search=${value}`);
                    window.nav.updatePagination();
                    document.getElementById("searchName").innerText = `Displaying results for: ${value}`;
                    lastUpdate = Date.now();
                }, timeout);
            }
        });
    }
})();

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