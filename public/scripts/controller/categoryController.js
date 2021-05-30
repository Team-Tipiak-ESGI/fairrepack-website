const categoryController = {};

categoryController.create = async function(form) {
    const formData = new FormData(form);

    authenticatedFetch(`/api/category/create.php`, "POST", await formDataToJSON(formData))
        .then(res => {
            return res.json();
        })
        .then(json => {
            alert("Category added");
            categoryVue.buildCategoryList(document.querySelector("tbody#categoryList"));
        });
}

categoryController.delete = function(id) {
    authenticatedFetch(`/api/category/delete.php`, "POST", JSON.stringify({id: id}))
        .then(res => {
            alert("Category deleted");
            categoryVue.buildCategoryList(document.querySelector("tbody#categoryList"));
        });
}
