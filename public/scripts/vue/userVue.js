const userVue = {};

userVue.buildInfoDiv = (div, user) => {

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

    authenticatedFetch(`/api/product/read.php?user=${id}`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(products => {
            productVue.buildProductList(products_div, products);
        });
}
