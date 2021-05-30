const addressController = {};

addressController.create = async function(form) {
    const formData = new FormData(form);

    authenticatedFetch(`/api/address/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Address added");
            addressVue.buildCategoryList(document.querySelector("tbody#addressList"));
        });
}

addressController.delete = function(id) {
    authenticatedFetch(`/api/address/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Address deleted");
            addressVue.buildCategoryList(document.querySelector("tbody#addressList"));
        });
}
