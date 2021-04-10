const productVue = {};

/**
 * Build the product list
 * @param {HTMLDivElement} div
 */
productVue.buildProductList = function (div) {
    authenticatedFetch("/api/product/read.php")
        .then(res => res.json())
        .then(products => {

            div.innerHTML = '';

            for (const product of products) {
                // Product card
                const div_1 = document.createElement(`div`);
                div_1.classList.add(`card`, `m-2`);
                div_1.style.width = `18rem`;

                const div_e = document.createElement(`div`);
                div_e.classList.add(`card-body`);
                const h5_3y = document.createElement(`h5`);
                h5_3y.classList.add(`card-title`);

                div_e.append(h5_3y);
                h5_3y.innerText = `${product.brand} ${product.name}`; // Card title
                const p_40 = document.createElement(`p`);
                p_40.classList.add(`card-text`);

                div_e.append(p_40);
                p_40.innerText = product.description; // Card content
                const a_42 = document.createElement(`a`);
                a_42.href = `/product.html?id=${product.id}`;
                a_42.classList.add(`btn`, `btn-primary`);

                div_e.append(a_42);
                a_42.innerText = `Voir le produit`;

                div_1.append(div_e);

                div.append(div_1);
            }
        });
}

/**
 * Add references to select
 * @param {HTMLSelectElement} select Select element to update
 */
productVue.buildReferenceSelect = function (select) {
    referenceModel.read()
        .then(references => {
            for (const reference of references) {
                const option = document.createElement('option');

                option.value = reference.id_reference;
                option.innerText = `${reference.brand} ${reference.name}`;

                select.append(option);
            }
        });
}