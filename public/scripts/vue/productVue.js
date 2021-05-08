const productVue = {};

productVue.buildInfoDiv = function(div, product) {
    div.innerHTML = '';

    // Product info
    const ul_1 = document.createElement(`ul`);
    const li_c = document.createElement(`li`);
    const text_3d = document.createTextNode(`Vendeur : `);
    li_c.append(text_3d);
    const a_3e = document.createElement(`a`);
    a_3e.href = `/user.php?id=${product.user}`;

    li_c.append(a_3e);
    a_3e.innerText = `${product.user}`;

    ul_1.append(li_c);
    const li_e = document.createElement(`li`);

    ul_1.append(li_e);
    li_e.innerText = `Dernier prix : ${product.offers?.[0]?.price || 'N/A'}`;
    const li_g = document.createElement(`li`);
    const text_4h = document.createTextNode(`Produit : `);
    li_g.append(text_4h);
    const a_4i = document.createElement(`a`);
    a_4i.href = `/reference.php?id=${product.reference}`;

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

    div.append(ul_1);
}

productVue.buildOfferDiv = function(div, product) {
    div.innerHTML = '';

    if (product.offers === undefined) return;

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

        div.append(a_2);
    }
}

/**
 * Build the product page
 * @param info_div
 * @param offer_div
 * @param {number|undefined} page Page number
 */
productVue.buildProductPage = function (info_div, offer_div, page = 0) {
    const p = getPage(page);
    authenticatedFetch(`/api/product/read.php?id=${p.pageId}&${p.urlParams}`)
        .then(res => res.json())
        .then(json => {
            const product = json.items;

            productVue.buildInfoDiv(info_div, product);
            productVue.buildOfferDiv(offer_div, product);

            // Hide offer form if user is not owner or admin or if product is already accepted
            const payload = getToken().payload;
            const isOwner = payload.uuid === product.user;
            const isAdmin = payload.type === "admin";
            const productRegistered = product.state === "registered";
            const lastOffer = product.offers[0];
            const lastOfferIsMine = lastOffer.user === payload.uuid;

            const acceptLastOffer = document.querySelector("button#acceptLastOffer");
            if (!lastOfferIsMine && productRegistered)
                acceptLastOffer.classList.remove("d-none");
            else
                acceptLastOffer.classList.add("d-none");

            const declineLastOffer = document.querySelector("button#declineLastOffer");
            const addOfferForm = document.querySelector("form#addOfferForm");

            if ((isOwner || isAdmin) && productRegistered) {
                declineLastOffer.classList.remove("d-none");
                addOfferForm.classList.remove("d-none");
            } else {
                declineLastOffer.classList.add("d-none");
                addOfferForm.classList.add("d-none");
            }

            if (isOwner && product.state === "accepted")
                document.querySelector("button#getColissimo").classList.remove("d-none");
            else
                document.querySelector("button#getColissimo").classList.add("d-none");
        });
}

productVue.buildProductList = function (div, products) {
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
        p_40.innerText = `${product.description || "-"}\nEtat : ${product.state}\nOffres : ${product.offer_count}`; // Card content
        const a_42 = document.createElement(`a`);
        a_42.href = `/product.php?id=${product.id}`;
        a_42.classList.add(`btn`, `btn-primary`);

        div_e.append(a_42);
        a_42.innerText = `View product`;

        div_1.append(div_e);

        div.append(div_1);
    }
}
