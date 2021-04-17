const referenceVue = {};

/**
 * Build the reference list
 * @param {HTMLDivElement} div
 */
referenceVue.buildReferenceList = function (div) {
    authenticatedFetch("/api/reference/read.php?state=in_stock")
        .then(res => res.json())
        .then(references => {
            div.innerHTML = '';

            for (const reference of references) {
                // Product card
                const div_1 = document.createElement(`div`);
                div_1.classList.add(`card`, `m-2`);
                div_1.style.width = `18rem`;

                const div_e = document.createElement(`div`);
                div_e.classList.add(`card-body`);
                const h5_3y = document.createElement(`h5`);
                h5_3y.classList.add(`card-title`);

                div_e.append(h5_3y);
                h5_3y.innerText = `${reference.brand} ${reference.name}`; // Card title
                const p_40 = document.createElement(`p`);
                p_40.classList.add(`card-text`);

                div_e.append(p_40);
                p_40.innerText = `Stocks: ${reference.stocks}`; // Card content
                const a_42 = document.createElement(`a`);
                a_42.href = `/reference.html?id=${reference.id}`;
                a_42.classList.add(`btn`, `btn-primary`);

                div_e.append(a_42);
                a_42.innerText = `View product`;

                div_1.append(div_e);

                div.append(div_1);
            }
        });
}

/**
 * Add references to select
 * @param {HTMLSelectElement} select Select element to update
 */
referenceVue.buildReferenceSelect = function (select) {
    referenceModel.read()
        .then(references => {
            for (const reference of references) {
                const option = document.createElement('option');

                option.value = reference.id;
                option.innerText = `${reference.brand} ${reference.name}`;

                select.append(option);
            }
        });
}

/**
 * Build the product list of a given reference
 * @param {HTMLDivElement} div Div to add product list
 * @param {string} reference_id Reference's UUID
 */
referenceVue.buildProductList = function (div, reference_id) {
    authenticatedFetch(`/api/product/read.php?reference=${reference_id}`)
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
                p_40.innerText = `${product.description}\n${product.state}`; // Card content
                const a_42 = document.createElement(`a`);
                a_42.href = `/product.html?id=${product.id}`;
                a_42.classList.add(`btn`, `btn-primary`);

                div_e.append(a_42);
                a_42.innerText = `View product`;

                div_1.append(div_e);

                div.append(div_1);
            }
        });
}
