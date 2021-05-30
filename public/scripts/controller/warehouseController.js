const warehouseController = {};

warehouseController.create = async function(form) {
    const formData = new FormData(form);

    authenticatedFetch(`/api/warehouse/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Warehouse added");
            warehouseVue.buildWarehouseList(document.querySelector("tbody#warehouseList"));
        });
}