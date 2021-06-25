const cartController = {};

/**
 * Add a product to the user's cart
 * @param {string} product_id Product's UUID
 */
cartController.addProduct = function(product_id) {
    let currentCart = this.get();

    // Check if product is already in cart
    const product = currentCart[product_id];
    if (product !== undefined) {
        addNotificationToast("Can't add to cart", `This product is already in your cart.`);
        return;
    }

    // Get the product information
    authenticatedFetch(`/api/product/read.php?id=${product_id}`)
        .then(res => res.json())
        .then(json => {
            const product = json.items;

            // Add the product to the cart
            if (currentCart[product_id] === undefined) {
                delete product.id;
                currentCart[product_id] = product;
                currentCart[product_id].count = 1;
            }

            // Update cart
            window.localStorage.setItem("cart", JSON.stringify(currentCart));

            // Send a notification to the user
            addNotificationToast("Added to cart", `${product.brand} ${product.name} added to cart`);
            cartVue.updateHeader();
        });
}

/**
 * Update the amount of products
 * @param {string} id ID of the product to change the amount
 * @param {number} count New product amount
 */
cartController.updateCount = function(id, count) {
    const currentCard = this.get();
    if (count <= 0)
        delete currentCard[id];
    else
        currentCard[id].count = parseInt(count);
    window.localStorage.setItem("cart", JSON.stringify(currentCard));
    cartVue.updateHeader();
}

/**
 * Get the cart from the browser's local storage
 * @returns {object}
 */
cartController.get = function() {
    return JSON.parse(window.localStorage.getItem("cart") || "{}");
}

/**
 * Get the total amount of products currently in cart
 * @returns {number}
 */
cartController.getTotal = function() {
    try {
        return Object.values(this.get()).map(p => parseInt(p.count)).reduce((a, c) => a += c);
    } catch (e) {
        return 0;
    }
}
