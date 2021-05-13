const referenceVue = {};

/**
 * Build the reference list
 * @param {HTMLDivElement} div
 * @param {number|undefined} page Page number
 */
referenceVue.buildReferenceList = function (div, page = 0) {
    authenticatedFetch(`/api/reference/read.php?${getPage(page).urlParams}`)
        .then(res => res.json())
        .then(json => {
            window.nav.setElementCount(json.count);

            const references = json.items;

            div.innerHTML = '';

            references.sort((a, b) => {
                if (b.stocks !== null || a.stocks !== null)
                    return (b.stocks || 0) - (a.stocks || 0);
                else
                    return (b.count || 0) - (a.count || 0);
            })

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
                p_40.innerText = `Stocks : ${reference.stocks || 0}\nEnregistrés : ${reference.count || 0}`; // Card content

                const a_42 = document.createElement(`a`);
                a_42.href = `/reference.php?id=${reference.id}`;
                a_42.classList.add(`btn`, `btn-primary`);
                a_42.innerText = `View products`;
                div_e.append(a_42);

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
        .then(json => {
            const references = json.items;
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
 * @param {number|undefined} page Page number
 */
referenceVue.buildProductList = function (div, page = 0) {
    const p = getPage(page);
    authenticatedFetch(`/api/product/read.php?reference=${p.pageId}&${p.urlParams}`)
        .then(res => res.json())
        .then(json => {
            window.nav.setElementCount(json.count);
            const products = json.items;
            productVue.buildProductList(div, products);
        });
}
