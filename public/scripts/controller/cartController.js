const cartController = {};

/**
 * Add a reference to cart
 * @deprecated
 * @param reference_id
 */
cartController.add = cartController.addReference;

cartController.addReference = function(reference_id) {
    const currentCart = this.get();

    if (currentCart.references === undefined) currentCart.references = {};

    authenticatedFetch(`/api/reference/read.php?id=${reference_id}`)
        .then(res => res.json())
        .then(json => {
            const reference = json.items;

            if (currentCart.references[reference_id] === undefined) {
                delete reference.id;
                currentCart.references[reference_id] = reference;
                currentCart.references[reference_id].count = 0;
            }

            currentCart.references[reference_id].count++;

            window.localStorage.setItem("cart", JSON.stringify(currentCart));
        });
}

cartController.addProduct = function(product_id) {
    const currentCart = this.get();

    if (currentCart.products === undefined) currentCart.products = {};

    authenticatedFetch(`/api/reference/read.php?id=${product_id}`)
        .then(res => res.json())
        .then(json => {
            const reference = json.items;

            if (currentCart.products[product_id] === undefined) {
                delete reference.id;
                currentCart.products[product_id] = reference;
                currentCart.products[product_id].count = 0;
            }

            currentCart.products[product_id].count++;

            window.localStorage.setItem("cart", JSON.stringify(currentCart));
        });
}

cartController.updateCount = function(reference_id, count) {
    const currentCard = this.get();
    currentCard[reference_id].count = count;
    window.localStorage.setItem("cart", JSON.stringify(currentCard));
}

cartController.get = function() {
    return JSON.parse(window.localStorage.getItem("cart") || "{}");
}

cartController.getTotal = function() {
    return Object.values(this.get()).reduce((p, c) => p + c);
}