const offerController = {};

offerController.create = function(form) {
    const formData = new FormData(form);

    const id = new URLSearchParams(window.location.search.substr(1)).get('id');

    formData.set("product", id);

    authenticatedFetch(`/api/offer/create.php`, "POST", formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            console.log(json);
            productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'), id);
        });
}