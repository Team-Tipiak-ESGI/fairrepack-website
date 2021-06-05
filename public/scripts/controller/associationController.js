const associationController = {};

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

associationController.delete = function(id) {
    authenticatedFetch(`/api/association/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Association deleted");
            associationVue.buildAssociationList(document.querySelector("tbody#associationList"));
        });
}
