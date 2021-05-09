const offerController = {};

offerController.create = async function(form) {
    const formData = new FormData(form);

    const id = getPage().pageId;

    formData.set("product", id);

    authenticatedFetch(`/api/offer/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'));
        });
}