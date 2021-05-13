const cartController = {};

cartController.addProduct = function(product_id) {
    const currentCart = this.get();

    if (currentCart.products === undefined) currentCart.products = {};
    else {
        const product = currentCart.products[product_id];
        currentCart.products[product_id].count++;
        window.localStorage.setItem("cart", JSON.stringify(currentCart));
        addNotificationToast("Added to cart", `${product.brand} ${product.name} added to cart`);
        return;
    }

    authenticatedFetch(`/api/product/read.php?id=${product_id}`)
        .then(res => res.json())
        .then(json => {
            const product = json.items;

            if (currentCart.products[product_id] === undefined) {
                delete product.id;
                currentCart.products[product_id] = product;
                currentCart.products[product_id].count = 0;
            }

            currentCart.products[product_id].count++;

            window.localStorage.setItem("cart", JSON.stringify(currentCart));
            addNotificationToast("Added to cart", `${product.brand} ${product.name} added to cart`);
        });
}

cartController.updateCount = function(id, count) {
    const currentCard = this.get();
    if (count <= 0)
        delete currentCard.products[id];
    else
        currentCard.products[id].count = count;
    window.localStorage.setItem("cart", JSON.stringify(currentCard));
}

cartController.get = function() {
    return JSON.parse(window.localStorage.getItem("cart") || "{}");
}

cartController.getTotal = function() {
    return Object.values(this.get()).reduce((p, c) => p + c);
}