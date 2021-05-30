const categoryVue = {};

/**
 *
 * @param {HTMLTableElement} tbody
 */
categoryVue.buildCategoryList = function (tbody) {
    tbody.innerHTML = "";

    authenticatedFetch("/api/category/read.php")
        .then(res => res.json())
        .then(json => {
            const categories = json.items;
            for (const category of categories) {
                const tr_3d = document.createElement(`tr`);
                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);
                tr_3d.append(th_xo);
                th_xo.innerText = `${category.id_category}`;

                const td_xq = document.createElement(`td`);
                tr_3d.append(td_xq);
                td_xq.innerText = `${category.name}`;

                const td_xp = document.createElement(`td`);
                tr_3d.append(td_xp);

                const button = document.createElement("button");
                button.innerText = "Remove";
                button.classList.add("btn", "btn-danger", "btn-sm");
                button.addEventListener("click", (e) => {
                    if (window.confirm("Are you sure you want to delete this category and all types associated with it?"))
                        categoryController.delete(category.id_category);
                });
                td_xp.append(button);

                tbody.append(tr_3d);
            }
        })
}
