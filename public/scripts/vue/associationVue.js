const associationVue = {};

/**
 *
 * @param {HTMLTableElement} tbody
 */
associationVue.buildAssociationList = function (tbody) {
    tbody.innerHTML = "";

    authenticatedFetch("/api/association/read.php")
        .then(res => res.json())
        .then(json => {
            const associations = json.items;
            for (const association of associations) {
                const tr_3d = document.createElement(`tr`);
                tr_3d.style.verticalAlign = "middle";

                const uuid = association.uuid_association;

                const th_xo = document.createElement(`th`);
                th_xo.setAttribute(`scope`, `row`);
                th_xo.innerText = uuid.slice(0, 5);
                tr_3d.append(th_xo);

                const td_xu = document.createElement(`td`);

                const img = document.createElement("img");
                img.src = `/image/association/${uuid}`;
                img.style.height = "5em";
                img.style.width = "5em";
                img.classList.add("d-block", "img-thumbnail", "card-img-top", "rounded", "p-0")
                img.style.objectFit = "cover";

                td_xu.append(img);
                tr_3d.append(td_xu);

                const td_xq = document.createElement(`td`);
                tr_3d.append(td_xq);
                td_xq.innerText = `${association.name}`;

                const td_xp = document.createElement(`td`);
                tr_3d.append(td_xp);

                const button = document.createElement("button");
                button.innerText = "Remove";
                button.classList.add("btn", "btn-danger", "btn-sm");
                button.addEventListener("click", (e) => {
                    if (window.confirm("Are you sure you want to delete this association?"))
                        associationController.delete(association.id_association);
                });
                td_xp.append(button);

                tbody.append(tr_3d);
            }
        })
}
