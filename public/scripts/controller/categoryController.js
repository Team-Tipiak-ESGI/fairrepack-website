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