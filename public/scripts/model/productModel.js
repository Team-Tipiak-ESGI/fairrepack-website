const productModel = {};

/**
 * Create a new product in the database
 * @param {string} json
 */
productModel.create = function(json) {
    return authenticatedFetch("/api/product/create.php", "POST", json);
}

productModel.update = function(product_id) {

}

productModel.delete = function(product_id) {

}
