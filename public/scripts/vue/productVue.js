const productVue = {};

/**
 * Build the product page
 * @param info_div
 * @param offer_div
 * @param {string} product_id Product's UUID
 */
productVue.buildProductPage = function (info_div, offer_div, product_id) {
    authenticatedFetch(`/api/product/read.php?id=${product_id}`)
        .then(res => res.json())
        .then(product => {
            info_div.innerHTML = '';

            // Product info
            const ul_1 = document.createElement(`ul`);
            const li_c = document.createElement(`li`);
            const text_3d = document.createTextNode(`Vendeur : `);
            li_c.append(text_3d);
            const a_3e = document.createElement(`a`);
            a_3e.href = `/user.html?id=${product.user}`;

            li_c.append(a_3e);
            a_3e.innerText = `${product.user}`;

            ul_1.append(li_c);
            const li_e = document.createElement(`li`);

            ul_1.append(li_e);
            li_e.innerText = `Dernier prix : ${product.offers[0].price}`;
            const li_g = document.createElement(`li`);
            const text_4h = document.createTextNode(`Produit : `);
            li_g.append(text_4h);
            const a_4i = document.createElement(`a`);
            a_4i.href = `/reference.html?id=${product.reference}`;

            li_g.append(a_4i);
            a_4i.innerText = `${product.brand} ${product.name}`;

            ul_1.append(li_g);
            const li_i = document.createElement(`li`);

            ul_1.append(li_i);
            li_i.innerText = `Qualité : ${product.quality}`;

            const li_j = document.createElement(`li`);

            ul_1.append(li_j);
            li_j.innerText = `Etat : ${product.state}`;
            const li_32 = document.createElement(`li`);

            ul_1.append(li_32);
            li_32.innerText = `Ajouté le ${new Date(product.created).format("%dd/%MM/%yyyy à %hh:%mm")}`;

            info_div.append(ul_1);

            offer_div.innerHTML = '';

            // Build offer list
            for (const offer of product.offers) {
                const a_2 = document.createElement(`a`);
                a_2.href = `#`;
                a_2.classList.add(`list-group-item`, `list-group-item-action`);
                const div_m = document.createElement(`div`);
                div_m.classList.add(`d-flex`, `w-100`, `justify-content-between`);
                const h5_66 = document.createElement(`h5`);
                h5_66.classList.add(`mb-1`);

                div_m.append(h5_66);
                h5_66.innerText = `${offer.user} propose ${offer.price}€`; // Title
                const small_68 = document.createElement(`small`);
                small_68.classList.add(`text-muted`);

                div_m.append(small_68);
                small_68.innerText = ``; // Top right

                a_2.append(div_m);
                const p_o = document.createElement(`p`);
                p_o.classList.add(`mb-1`);

                a_2.append(p_o);
                p_o.innerText = offer.note || 'N/A'; // Body
                const small_q = document.createElement(`small`);
                small_q.classList.add(`text-muted`);

                a_2.append(small_q);
                small_q.innerText = `Le ${new Date(offer.created).format("%dd/%MM/%yyyy à %hh:%mm")}`; // Footer

                offer_div.append(a_2);
            }

            console.log(product);
        });
}