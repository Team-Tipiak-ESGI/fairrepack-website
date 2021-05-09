const productController = {};

/**
 * Create a new product in the database
 * @param {HTMLFormElement} form
 */
productController.create = async function (form) {
    const formData = new FormData(form);
    productModel.create(await formDataToJSON(formData))
        .then((res) => {
            if (res.status === 201) {
                referenceVue.buildReferenceList(document.querySelector("div#referenceList"));
                return res.json();
            } else {
                throw res;
            }
        })
        .then(json => {
            const location = window.location;
            window.location.href = `${location.origin}/product.php?id=${json.uuid_product}`;
        })
        .catch((res) => {
            if (res.status === 401) {
                alert("You are not logged in.");
            } else {
                alert("Unknown error.")
            }
        })
}

productController.updateState = function (state, id = getPage().pageId) {
    productModel.update(JSON.stringify({id_product: id, state: state}))
        .then(res => {
            if (res.status === 201)
                return res.json();
            else
                throw res;
        })
        .then(json => {
            productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'));
        });

}
