const addressController = {};

/**
 * Makes a request to the API to create a new address from the given form
 * @param {HTMLFormElement} form Form with the address' information
 * @returns {Promise<void>}
 */
addressController.create = async function(form) {
    const formData = new FormData(form);
    formData.set("type", "pro");

    authenticatedFetch(`/api/address/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Address added");
            addressVue.buildAddressList(document.querySelector("tbody#addressList"));
        });
}

/**
 * Delete the address with the given ID
 * @param {string} id Address' ID
 */
addressController.delete = function(id) {
    authenticatedFetch(`/api/address/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Address deleted");
            addressVue.buildAddressList(document.querySelector("tbody#addressList"));
        });
}
