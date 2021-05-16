const userVue = {};

userVue.buildInfoDiv = (div, user) => {

}

userVue.updateAccountPage = () => {
    if (getToken().valid) {
        document.getElementById("signedOut")?.classList.add("d-none");
        document.getElementById("signedIn")?.classList.remove("d-none");
    } else {
        document.getElementById("signedOut")?.classList.remove("d-none");
        document.getElementById("signedIn")?.classList.add("d-none");
    }
}

userVue.buildProductDiv = (div, id) => {
    authenticatedFetch(`/api/product/read.php?user=${id}&state=registered`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(json => {
            productVue.buildProductList(div, json.items);
        });
}

userVue.basicUserInfo = (info_div, products_div, id) => {
    authenticatedFetch(`/api/user/read.php?id=${id}`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(user => {
            userVue.buildInfoDiv(info_div, user);
            console.log(user);
        });

    this.buildProductDiv(products_div, id);
}
