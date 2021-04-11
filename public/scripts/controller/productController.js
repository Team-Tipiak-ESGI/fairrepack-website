const productController = {};

/**
 * Create a new product in the database
 * @param {HTMLFormElement} form
 */
productController.create = function (form) {
    const formData = new FormData(form);
    productModel.create(formDataToJSON(formData))
        .then((res) => {
            referenceVue.buildReferenceList(document.querySelector("div#productList"));
        })
        .catch((res) => {
            if (res.status === 401) {
                alert("You are not logged in.");
            } else {
                alert("Unknown error.")
            }
        })
}