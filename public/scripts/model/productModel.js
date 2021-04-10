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
        })
        .catch((res) => {
            if (res.status === 401) {
                alert("You are not logged in.");
            } else {
                alert("Unknown error.")
            }
        });
}

productModel.update = function(product_id) {

}

productModel.delete = function(product_id) {

}
