const productController = {};

/**
 * Create a new product in the database
 * @param {HTMLFormElement|SubmitEvent} form
 */
productController.create = async function (e) {
    let form = e, spinner;
    if (e instanceof SubmitEvent) {
        form = e.target;
        e.preventDefault();
        e.stopPropagation();
        spinner = buttonSpinner(e.submitter);
    }

    const formData = new FormData(form);
    productModel.create(await formDataToJSON(formData))
        .then((res) => {
            spinner?.call();

            if (res.status === 201) {
                referenceVue.buildReferenceList(document.querySelector("div#referenceList"));
                return res.json();
            } else {
                throw res;
            }
        })
        .then(json => {
            window.location.href = `${window.location.origin}/product.php?id=${json.uuid_product}`;
        })
        .catch((res) => {
            if (res.status === 401) {
                alert("You are not logged in.");
            } else {
                alert("Unknown error.")
            }
        })

    return false;
}

/**
 * Update the state of the product
 * @param {string} state New product's state
 * @param {string} id Product's UUID
 */
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

/**
 * Update a product information
 * @param {HTMLFormElement} form Input form
 * @param {string} id UUID of the product, default to page's ID
 * @returns {Promise<void>}
 */
productController.update = async function (form, id = getPage().pageId) {
    const formData = new FormData(form);
    formData.set("id_product", id);

    productModel.update(await formDataToJSON(formData))
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
