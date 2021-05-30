const typeVue = {};

typeVue.buildCategorySelect = function (select) {
    select.innerHTML = "";

    authenticatedFetch("/api/category/read.php")
        .then(res => res.json())
        .then(json => {
            const categories = json.items;
            for (const category of categories) {
                const option = document.createElement('option');

                option.value = category.id_category;
                option.innerText = category.name;

                select.append(option);
            }
        });
}

/**
 *
 * @param {HTMLTableElement} tbody
 */
typeVue.buildTypeList = function (tbody) {
    tbody.innerHTML = "";

    authenticatedFetch("/api/type/read.php")
        .then(res => res.json())
        .then(json => {
            const types = json.items;
            for (const type of types) {
                const tr_3d = document.createElement(`tr`);
                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);

                tr_3d.append(th_xo);
                th_xo.innerText = `${type.id_type}`;
                const td_xq = document.createElement(`td`);

                tr_3d.append(td_xq);
                td_xq.innerText = `${type.name}`;
                const td_xs = document.createElement(`td`);

                tr_3d.append(td_xs);
                td_xs.innerText = `${type.category_name}`;

                tbody.append(tr_3d);
            }
        })
}
