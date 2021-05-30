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

warehouseController.delete = function(id) {
    authenticatedFetch(`/api/warehouse/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Warehouse deleted");
            warehouseVue.buildWarehouseList(document.querySelector("tbody#warehouseList"));
        });
}
