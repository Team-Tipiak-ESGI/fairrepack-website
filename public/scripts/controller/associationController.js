const associationController = {};

/**
 * Makes a request to the API to create a new association from the given form
 * @param {HTMLFormElement} form Form with the association' information
 * @returns {Promise<void>}
 */
associationController.create = async function(form) {
    const formData = new FormData(form);

    authenticatedFetch(`/api/association/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Association added");
            associationVue.buildAssociationList(document.querySelector("tbody#associationList"));
        });
}

/**
 * Delete the association with the given ID
 * @param {string} id association' ID
 */
associationController.delete = function(id) {
    authenticatedFetch(`/api/association/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Association deleted");
            associationVue.buildAssociationList(document.querySelector("tbody#associationList"));
        });
}
