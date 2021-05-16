/**
 * This JavaScript file must be present on every pages
 */

function renewToken() {
    if (getToken().token === null) return;
    const expiringDate = new Date(getToken()?.payload?.expiry * 1000);

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