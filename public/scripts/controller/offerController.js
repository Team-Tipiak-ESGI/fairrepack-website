const offerController = {};

offerController.create = async function(form) {
    const formData = new FormData(form);

    // Get the ID of the current page (id of the product)
    const id = getPage().pageId;

    // Add the product to the form data
    formData.set("product", id);

    authenticatedFetch(`/api/offer/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'));
        });
}