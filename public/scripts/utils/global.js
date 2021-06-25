/**
 * This JavaScript file must be present on every pages
 */

/**
 * Function called just before the JWT expired to renew it
 */
function renewToken() {
    // If token is not defined, do nothing
    if (getToken().token === null) return;
    // Get expiring date of the token
    const expiringDate = new Date(getToken()?.payload?.expiry * 1000);

    // If the token has expired, send a notification the the user to relogin
    if (!getToken().valid && window.location.pathname !== "/account.php") {
        const parent = document.createElement("div");
        const toast = addNotificationToast("Session expired", parent, expiringDate);

        const text_1 = document.createTextNode(`Please `);
        parent.append(text_1);
        const a_2 = document.createElement(`a`);
        a_2.href = `/account.php`;

        parent.append(a_2);
        a_2.innerText = `log in`;
        const text_3 = document.createTextNode(` or `);
        parent.append(text_3);
        const a_4 = document.createElement(`a`);
        a_4.href = `#`;

        parent.append(a_4);
        a_4.innerText = `don't show again`;
        a_4.addEventListener("click", (e) => {
            UserController.logout();
            toast.remove();
        });
        const text_5 = document.createTextNode(`.`);
        parent.append(text_5);

        return;
    }

    // Get renew timeout in milliseconds
    const renewIn = Math.max(expiringDate - Date.now() - 10000 /* 10 seconds */, 10000);

    console.log("Renewing session in " + renewIn + " seconds");

    // Create a timeout function to renew the token automatically
    setTimeout(() => {
        // Make a request to the API
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
                // Error handling
                addNotificationToast("Oops", "Your session could not be renewed, please <a href='/account.php'>log in</a> to renew your session.");
            });
    }, renewIn)
}

/**
 * Update website's navbar
 */
function updateHeaderAccount() {
    const headerAccount = document.getElementById("headerAccount");
    const token = getToken();

    if (token.valid) {
        if (token.payload?.type === "admin")
            document.getElementById("headerAdmin").classList.remove("d-none");
        headerAccount.innerText = i18n("php.header.profil");
    }
}

window.addEventListener("load", renewToken);
window.addEventListener("load", cartVue.updateHeader);
window.addEventListener("load", updateHeaderAccount);

// Live search bar
(function () {
    const SEARCH_PAGE = "/references.php";
    // On search bar's form submitted, redirect to the references page with search keywords
    document.getElementById("searchForm").addEventListener("submit", (e) => {
        if (window.location.pathname !== SEARCH_PAGE) {
            window.location.href = `${location.origin + SEARCH_PAGE}?search=${e.target.elements["search"].value}`;
        }

        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    // If user is currently on the references page
    if (window.location.pathname === SEARCH_PAGE) {
        // Theses variables are used to reduce the amount of requests made to the API
        let lastUpdate = 0, update, lastValue;
        const searchBar = document.getElementById("searchBar");

        // Get the current search value
        const search = getPage().search;

        // If a value is already present in the URL, display the results
        if (search) {
            searchBar.value = search;
            document.getElementById("searchName").innerText = `Displaying results for: ${search}`;
        }

        // Keydown and keyup events for a more fluid live search
        searchBar.addEventListener("keydown", e => lastValue = e.target.value)
        searchBar.addEventListener("keyup", e => {
            const value = e.target.value;
            if (value !== lastValue && window.location.pathname === SEARCH_PAGE) {
                if (update !== undefined) clearTimeout(update);

                let timeout = Date.now() - lastUpdate < 200 ? 200 : 0;

                update = setTimeout(() => {
                    // Update the URL and add the search parameter to it
                    window.history.pushState('', '', `${location.origin + SEARCH_PAGE}?search=${value}`);
                    window.nav.updatePagination(); // Pagination handles the search using the search URL parameter
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