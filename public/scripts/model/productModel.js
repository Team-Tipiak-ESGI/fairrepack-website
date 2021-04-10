const productModel = {};

/**
 * Create a new product in the database
 * @param {HTMLFormElement} form
 */
productModel.create = function(form) {
    const formData = new FormData(form);

    authenticatedFetch("/api/product/create.php", "POST", formDataToJSON(formData))
        .then((res) => {
            productVue.buildProductList(document.querySelector("div#productList"));
        });
}

productModel.update = function(product_id) {

}

productModel.delete = function(product_id) {

}
