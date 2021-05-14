const cartController = {};

cartController.addProduct = function(product_id) {
    let currentCart = this.get();

    const product = currentCart[product_id];
    if (product !== undefined) {
        currentCart[product_id].count++;
        window.localStorage.setItem("cart", JSON.stringify(currentCart));

        addNotificationToast("Added to cart", `${product.brand} ${product.name} added to cart`);
        cartVue.updateHeader();
        return;
    }

    authenticatedFetch(`/api/product/read.php?id=${product_id}`)
        .then(res => res.json())
        .then(json => {
            const product = json.items;

            if (currentCart[product_id] === undefined) {
                delete product.id;
                currentCart[product_id] = product;
                currentCart[product_id].count = 0;
            }

            currentCart[product_id].count++;

            window.localStorage.setItem("cart", JSON.stringify(currentCart));

            addNotificationToast("Added to cart", `${product.brand} ${product.name} added to cart`);
            cartVue.updateHeader();
        });
}

cartController.updateCount = function(id, count) {
    const currentCard = this.get();
    if (count <= 0)
        delete currentCard[id];
    else
        currentCard[id].count = count;
    window.localStorage.setItem("cart", JSON.stringify(currentCard));
    cartVue.updateHeader();
}

cartController.get = function() {
    return JSON.parse(window.localStorage.getItem("cart") || "{}");
}

cartController.getTotal = function() {
    try {
        return Object.values(this.get()).map(p => p.count).reduce((a, c) => a += c);
    } catch (e) {
        return 0;
    }
}
