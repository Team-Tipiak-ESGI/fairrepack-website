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