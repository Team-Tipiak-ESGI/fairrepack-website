const warehouseVue = {};

warehouseVue.buildAddressSelect = function (select) {
    authenticatedFetch("/api/address/read.php")
        .then(res => res.json())
        .then(json => {
            const addresses = json.items;
            for (const address of addresses) {
                const option = document.createElement('option');

                option.value = address.id_address;
                option.innerText = `${address.country} - ${address.postal_code} - ${address.address_line1}`;

                select.append(option);
            }
        });
}

/**
 *
 * @param {HTMLTableElement} tbody
 */
warehouseVue.buildWarehouseList = function (tbody) {
    authenticatedFetch("/api/warehouse/read.php")
        .then(res => res.json())
        .then(json => {
            const warehouses = json.items;
            for (const warehouse of warehouses) {
                const tr_3d = document.createElement(`tr`);
                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);

                tr_3d.append(th_xo);
                th_xo.innerText = `${warehouse.id_warehouse}`;
                const td_xq = document.createElement(`td`);

                tr_3d.append(td_xq);
                td_xq.innerText = `${warehouse.name}`;
                const td_xs = document.createElement(`td`);

                tr_3d.append(td_xs);
                td_xs.innerText = `${warehouse.country}`;
                const td_xu = document.createElement(`td`);

                tr_3d.append(td_xu);
                td_xu.innerText = `${warehouse.postal_code}`;

                tbody.append(tr_3d);
            }
        })
}
