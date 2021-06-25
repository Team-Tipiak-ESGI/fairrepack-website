const userVue = {};

/**
 * Build user's information div
 * @param {HTMLDivElement} div
 * @param {object} user User object
 */
userVue.buildInfoDiv = function (div, user) {
    const h1_c = document.createElement("h2");
    h1_c.innerText = user.information.username ?? "";
    div.append(h1_c);

    const div_e = document.createElement("div");
    const strong_3x = document.createElement("strong");
    strong_3x.innerText = "Account creation: ";
    div_e.append(strong_3x);

    const text_3y = document.createTextNode(user.information.created);
    div_e.append(text_3y);

    div.append(div_e);

    const div_g = document.createElement("div");
    const strong_4h = document.createElement("strong");
    strong_4h.innerText = "Language: ";
    div_g.append(strong_4h);

    const text_4i = document.createTextNode(user.information.language);
    div_g.append(text_4i);

    div.append(div_g);

    const div_i = document.createElement("div");
    const strong_51 = document.createElement("strong");
    strong_51.innerText = "User type: ";
    div_i.append(strong_51);

    const text_52 = document.createTextNode(user.information.user_type);
    div_i.append(text_52);

    div.append(div_i);
}

/**
 * Update user's own account page
 * @param {string} uuid User's uuid
 */
userVue.updateAccountPage = (uuid) => {
    // If is logged in, show some buttons
    if (getToken().valid) {
        document.getElementById("signedOut")?.classList.add("d-none");
        document.getElementById("signedIn")?.classList.remove("d-none");
    } else {
        document.getElementById("signedOut")?.classList.remove("d-none");
        document.getElementById("signedIn")?.classList.add("d-none");
    }

    // Get user information and update page
    authenticatedFetch(`/api/user/read.php?id=${uuid}`)
        .then(res => res.json())
        .then(json => {
            // Fill up the account form with current values
            const form = document.getElementById("updateAccountForm");
            for (const element of form.elements) {
                if (!element.hasAttribute("data-name")) continue;
                const k = element.getAttribute("data-name");
                element.value = json.information[k] ?? json.address[k] ?? "";
            }
        });
}

/**
 * Get and display all products from a user onto the page
 * @param {HTMLDivElement} div
 * @param {string} id User uuid
 */
userVue.buildProductDiv = function (div, id) {
    authenticatedFetch(`/api/product/read.php?user=${id}`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(json => {
            productVue.buildProductList(div, json.items);
        });
}

/**
 * Build user page
 * @param {HTMLDivElement} info_div
 * @param {HTMLDivElement} products_div
 * @param {string} id User uuid
 */
userVue.basicUserInfo = function (info_div, products_div, id) {
    authenticatedFetch(`/api/user/read.php?id=${id}`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(user => {
            userVue.buildInfoDiv(info_div, user);
        });

    this.buildProductDiv(products_div, id);
}
