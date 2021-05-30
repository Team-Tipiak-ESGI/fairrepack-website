const addressVue = {};

/**
 *
 * @param {HTMLTableElement} tbody
 */
addressVue.buildAddressList = function (tbody) {
    tbody.innerHTML = "";

    authenticatedFetch("/api/address/read.php")
        .then(res => res.json())
        .then(json => {
            const addresses = json.items;
            for (const address of addresses) {
                const tr_3d = document.createElement(`tr`);

                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);
                tr_3d.append(th_xo);
                th_xo.innerText = `${address.id_address}`;

                const td_xq = document.createElement(`td`);
                tr_3d.append(td_xq);
                td_xq.innerText = `${address.country}`;

                const td1 = document.createElement(`td`);
                tr_3d.append(td1);
                td1.innerText = `${address.owner_name}`;

                const td2 = document.createElement(`td`);
                tr_3d.append(td2);
                td2.innerText = `${address.address_line1}`;

                const td3 = document.createElement(`td`);
                tr_3d.append(td3);
                td3.innerText = `${address.address_line2}`;

                const td4 = document.createElement(`td`);
                tr_3d.append(td4);
                td4.innerText = `${address.city}`;

                const td5 = document.createElement(`td`);
                tr_3d.append(td5);
                td5.innerText = `${address.state}`;

                const td6 = document.createElement(`td`);
                tr_3d.append(td6);
                td6.innerText = `${address.postal_code}`;

                const td7 = document.createElement(`td`);
                tr_3d.append(td7);
                td7.innerText = `${address.phone_number}`;

                const td8 = document.createElement(`td`);
                tr_3d.append(td8);
                td8.innerText = `${address.additional_info}`;

                const td_xp = document.createElement(`td`);
                tr_3d.append(td_xp);

                const button = document.createElement("button");
                button.innerText = "Remove";
                button.classList.add("btn", "btn-danger", "btn-sm");
                button.addEventListener("click", (e) => {
                    if (window.confirm("Are you sure you want to delete this category and all types associated with it?"))
                        categoryController.delete(address.id_category);
                });
                td_xp.append(button);

                tbody.append(tr_3d);
            }
        })
}
