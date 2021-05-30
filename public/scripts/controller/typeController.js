const typeController = {};

typeController.create = async function(form) {
    const formData = new FormData(form);

    authenticatedFetch(`/api/type/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Type added");
            typeVue.buildTypeList(document.querySelector("tbody#typeList"));
        });
}

typeController.delete = function(id) {
    authenticatedFetch(`/api/type/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Type deleted");
            typeVue.buildTypeList(document.querySelector("tbody#typeList"));
        });
}
