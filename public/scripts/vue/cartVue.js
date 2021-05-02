const cartVue = {};

cartVue.buildProductList = function(div, cart = cartController.get()) {
    for (const key in cart) {
        if (cart.hasOwnProperty(key)) {
            const reference = cart[key];

            div.append(this.buildCartElement(reference))
        }
    }
}

cartVue.buildCartElement = function(reference) {

}
