const warehouseVue = {};

/**
 *
 * @param {HTMLTableElement} tbody
 */
warehouseVue.buildWarehouseList = function (tbody) {
    tbody.innerHTML = "";

    authenticatedFetch("/api/warehouse/read.php")
        .then(res => res.json())
        .then(json => {
            const warehouses = json.items;
            for (const warehouse of warehouses) {
                const tr_3d = document.createElement(`tr`);

                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);
                th_xo.innerText = `${warehouse.id_warehouse}`;
                tr_3d.append(th_xo);

                const td_xq = document.createElement(`td`);
                tr_3d.append(td_xq);
                td_xq.innerText = `${warehouse.name}`;

                const td_xs = document.createElement(`td`);
                tr_3d.append(td_xs);
                td_xs.innerText = `${warehouse.country}`;

                const td_xu = document.createElement(`td`);
                tr_3d.append(td_xu);
                td_xu.innerText = `${warehouse.postal_code}`;

                const td_xp = document.createElement(`td`);
                tr_3d.append(td_xp);

                const button = document.createElement("button");
                button.innerText = "Remove";
                button.classList.add("btn", "btn-danger", "btn-sm");
                button.addEventListener("click", (e) => {
                    if (window.confirm("Are you sure you want to delete this warehouse?"))
                        warehouseController.delete(warehouse.id_warehouse);
                });
                td_xp.append(button);

                tbody.append(tr_3d);
            }
        })
}
