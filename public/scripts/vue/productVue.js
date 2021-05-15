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

productVue.buildElement = function (div, product) {

    div.innerHTML = '';

    const div_0_1 = document.createElement(`div`);
    div_0_1.classList.add(`card`);
    const div_0_1_2 = document.createElement(`div`);
    div_0_1_2.classList.add(`card-header`);
    const h5_0_1_2_2 = document.createElement(`h5`);
    h5_0_1_2_2.classList.add(`card-title`);
    const text_0_1_2_2_1 = document.createTextNode(`Product : `);
    h5_0_1_2_2.append(text_0_1_2_2_1);
    const a_4i = document.createElement(`a`);
    a_4i.href = `/reference.php?id=${product.reference}`;
    h5_0_1_2_2.append(a_4i);
    a_4i.innerText = `${product.brand} ${product.name}`;

    div_0_1_2.append(h5_0_1_2_2);

    div_0_1.append(div_0_1_2);
    const div_0_1_4 = document.createElement(`div`);
    div_0_1_4.id = `carouselCard`;
    div_0_1_4.classList.add(`carousel`, `slide`);
    div_0_1_4.setAttribute(`data-bs-ride`, `carousel`);
    const div_0_1_4_2 = document.createElement(`div`);
    div_0_1_4_2.classList.add(`carousel-inner`);

    const count = parseInt(product.image_count);
    const uuid = product.id;

    for (let i = 0; i < count; i++){
        const url = `/image/${uuid}/${i+1}`;

        const image_div = document.createElement(`div`);
        image_div.classList.add(`carousel-item`);
        if (i == 0){
            image_div.classList.add(`active`);
        }
        image_div.setAttribute(`data-bs-interval`, `10000`);
        const img = document.createElement(`img`);
        img.src = `${url}`;
        img.classList.add(`d-block`, `img-thumbnail`, `card-img-top`, `rounded`);
        img.style.maxHeight = "350px";

        image_div.append(img);
        div_0_1_4_2.append(image_div);
    }

    /*
    div_0_1_4_2_2.classList.add(`carousel-item`, `active`);
    div_0_1_4_2_2.setAttribute(`data-bs-interval`, `10000`);
    const img_0_1_4_2_2_2 = document.createElement(`img`);
    img_0_1_4_2_2_2.src = `public/assets/sad.png`;
    img_0_1_4_2_2_2.classList.add(`d-block`, `img-thumbnail`, `card-img-top`);

    div_0_1_4_2_2.append(img_0_1_4_2_2_2);

    div_0_1_4_2.append(div_0_1_4_2_2);
    const div_0_1_4_2_4 = document.createElement(`div`);
    div_0_1_4_2_4.classList.add(`carousel-item`);
    div_0_1_4_2_4.setAttribute(`data-bs-interval`, `10000`);
    const img_0_1_4_2_4_2 = document.createElement(`img`);
    img_0_1_4_2_4_2.src = `public/assets/ELr5LshXYAIOwvt.jpg`;
    img_0_1_4_2_4_2.classList.add(`d-block`, `img-thumbnail`, `card-img-top`);

    div_0_1_4_2_4.append(img_0_1_4_2_4_2);

    div_0_1_4_2.append(div_0_1_4_2_4);
    const div_0_1_4_2_6 = document.createElement(`div`);
    div_0_1_4_2_6.classList.add(`carousel-item`);
    div_0_1_4_2_6.setAttribute(`data-bs-interval`, `10000`);
    const img_0_1_4_2_6_2 = document.createElement(`img`);
    img_0_1_4_2_6_2.src = `public/assets/giggle.gif`;
    img_0_1_4_2_6_2.classList.add(`d-block`, `img-thumbnail`, `card-img-top`);

    div_0_1_4_2_6.append(img_0_1_4_2_6_2);
    div_0_1_4_2.append(div_0_1_4_2_6); */

    div_0_1_4.append(div_0_1_4_2);


    const button_0_1_4_4 = document.createElement(`button`);
    button_0_1_4_4.classList.add(`carousel-control-prev`);
    button_0_1_4_4.type = `button`;
    button_0_1_4_4.setAttribute(`data-bs-target`, `#carouselCard`);
    button_0_1_4_4.setAttribute(`data-bs-slide`, `prev`);
    const span_0_1_4_4_2 = document.createElement(`span`);
    span_0_1_4_4_2.classList.add(`carousel-control-prev-icon`);
    span_0_1_4_4_2.setAttribute(`aria-hidden`, `true`);

    button_0_1_4_4.append(span_0_1_4_4_2);
    const span_0_1_4_4_4 = document.createElement(`span`);
    span_0_1_4_4_4.classList.add(`visually-hidden`);
    const text_0_1_4_4_4_1 = document.createTextNode(`Previous`);
    span_0_1_4_4_4.append(text_0_1_4_4_4_1);

    button_0_1_4_4.append(span_0_1_4_4_4);

    div_0_1_4.append(button_0_1_4_4);
    const button_0_1_4_6 = document.createElement(`button`);
    button_0_1_4_6.classList.add(`carousel-control-next`);
    button_0_1_4_6.type = `button`;
    button_0_1_4_6.setAttribute(`data-bs-target`, `#carouselCard`);
    button_0_1_4_6.setAttribute(`data-bs-slide`, `next`);
    const span_0_1_4_6_2 = document.createElement(`span`);
    span_0_1_4_6_2.classList.add(`carousel-control-next-icon`);
    span_0_1_4_6_2.setAttribute(`aria-hidden`, `true`);

    button_0_1_4_6.append(span_0_1_4_6_2);
    const span_0_1_4_6_4 = document.createElement(`span`);
    span_0_1_4_6_4.classList.add(`visually-hidden`);
    const text_0_1_4_6_4_1 = document.createTextNode(`Next`);
    span_0_1_4_6_4.append(text_0_1_4_6_4_1);

    button_0_1_4_6.append(span_0_1_4_6_4);

    div_0_1_4.append(button_0_1_4_6);

    div_0_1.append(div_0_1_4);
    const div_0_1_6 = document.createElement(`div`);
    div_0_1_6.classList.add(`card-body`);
    const ul_0_1_6_2 = document.createElement(`ul`);
    ul_0_1_6_2.classList.add(`list-group`);
    const li_0_1_6_2_2 = document.createElement(`li`);
    li_0_1_6_2_2.classList.add(`list-group-item`, `card-text`);
    const text_0_1_6_2_2_1 = document.createTextNode(`Quality : ${product.quality}`);
    li_0_1_6_2_2.append(text_0_1_6_2_2_1);

    ul_0_1_6_2.append(li_0_1_6_2_2);
    const li_0_1_6_2_4 = document.createElement(`li`);
    li_0_1_6_2_4.classList.add(`list-group-item`, `card-text`);
    const text_0_1_6_2_4_1 = document.createTextNode(`Last Price : ${product.offers?.[0]?.price || 'N/A'}`);
    li_0_1_6_2_4.append(text_0_1_6_2_4_1);

    ul_0_1_6_2.append(li_0_1_6_2_4);
    const li_0_1_6_2_6 = document.createElement(`li`);
    li_0_1_6_2_6.classList.add(`list-group-item`, `card-text`);
    const text_0_1_6_2_6_1 = document.createTextNode(`State: ${product.state}`);
    li_0_1_6_2_6.append(text_0_1_6_2_6_1);

    ul_0_1_6_2.append(li_0_1_6_2_6);
    const li_0_1_6_2_8 = document.createElement(`li`);
    li_0_1_6_2_8.classList.add(`list-group-item`, `card-text`);
    const text_0_1_6_2_8_1 = document.createTextNode(`Seller: `);
    li_0_1_6_2_8.append(text_0_1_6_2_8_1);
    const a_0_1_6_2_8_2 = document.createElement(`a`);
    a_0_1_6_2_8_2.href = `/user.php?id=${product.user}`;
    li_0_1_6_2_8.append(a_0_1_6_2_8_2);
    a_0_1_6_2_8_2.innerText = `${product.user}`;

    ul_0_1_6_2.append(li_0_1_6_2_8);

    div_0_1_6.append(ul_0_1_6_2);

    div_0_1.append(div_0_1_6);
    const div_0_1_8 = document.createElement(`div`);
    div_0_1_8.classList.add(`card-footer`, `text-muted`);
    const text_0_1_8_1 = document.createTextNode(`Added : ${new Date(product.created).format("%dd/%MM/%yyyy à %hh:%mm")}`);
    div_0_1_8.append(text_0_1_8_1);

    div_0_1.append(div_0_1_8);

    div.append(div_0_1);
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

productVue.buildImageDiv = function(image_div, product) {
    const count = parseInt(product.image_count);
    const uuid = product.id;

    for (let i = 0; i < count; i++) {
        const url = `/image/${uuid}/${i + 1}`;

        const div = document.createElement("div");
        div.classList.add("col", "d-flex", "justify-content-center");

        const img = document.createElement(`img`);
        img.classList.add("img-fluid");
        img.src = url;
        img.style.maxHeight = "250px";

        div.append(img);
        image_div.append(div);
    }
}

/**
 * Build the product page
 * @param info_div
 * @param offer_div
 * @param image_div
 * @param {number|undefined} page Page number
 */
productVue.buildProductPage = function (info_div, offer_div, image_div, page = 0) {
    const p = getPage(page);
    authenticatedFetch(`/api/product/read.php?id=${p.pageId}&${p.urlParams}`)
        .then(res => res.json())
        .then(json => {
            const product = json.items;

            productVue.buildElement(info_div, product);
            //productVue.buildInfoDiv(info_div, product);
            productVue.buildOfferDiv(offer_div, product);
            //productVue.buildImageDiv(image_div, product);

            // Update page info & buttons

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

        const btn_43 = document.createElement(`btn`);
        btn_43.classList.add(`btn`, `btn-secondary`, `me-2`);
        btn_43.innerText = `Add to cart`;
        btn_43.addEventListener("click", (e) => {
            cartController.addProduct(product.id);
        });
        div_e.append(btn_43);
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

productVue.addImageField = function (button) {
    const parent = button.parentElement;
    const children_count = parent.children.length;

    if (children_count >= 3) {
        button.disabled = true;
        button.classList.add("disabled");
    }

    const input = document.createElement(`input`);
    input.classList.add(`form-control`, `mb-3`);
    input.type = `file`;
    input.name = `image`;

    parent.prepend(input);
}

function buildElement(parent) {
    const div_0_1 = document.createElement(`div`);
    div_0_1.classList.add(`card`);
    div_0_1.style.width = `18rem`;
    const img_0_1_2 = document.createElement(`img`);
    img_0_1_2.src = `public/assets/200x200.png`;
    img_0_1_2.classList.add(`card-img-top`);
    img_0_1_2.setAttribute(`alt`, `200par200`);

    div_0_1.append(img_0_1_2);
    const div_0_1_4 = document.createElement(`div`);
    div_0_1_4.classList.add(`card-body`);
    const h5_0_1_4_2 = document.createElement(`h5`);
    h5_0_1_4_2.classList.add(`card-title`);
    const text_0_1_4_2_1 = document.createTextNode(`Card title`);
    h5_0_1_4_2.append(text_0_1_4_2_1);

    div_0_1_4.append(h5_0_1_4_2);
    const p_0_1_4_4 = document.createElement(`p`);
    p_0_1_4_4.classList.add(`card-text`);
    const text_0_1_4_4_1 = document.createTextNode(`Some quick example text to build on the card title and make up the bulk of the card's content.`);
    p_0_1_4_4.append(text_0_1_4_4_1);

    div_0_1_4.append(p_0_1_4_4);
    const a_0_1_4_6 = document.createElement(`a`);
    a_0_1_4_6.href = `#`;
    a_0_1_4_6.classList.add(`btn`, `btn-primary`);
    const text_0_1_4_6_1 = document.createTextNode(`Add to cart`);
    a_0_1_4_6.append(text_0_1_4_6_1);

    div_0_1_4.append(a_0_1_4_6);
    const a_0_1_4_8 = document.createElement(`a`);
    a_0_1_4_8.href = `#`;
    a_0_1_4_8.classList.add(`btn`, `btn-secondary`);
    const text_0_1_4_8_1 = document.createTextNode(`View Product`);
    a_0_1_4_8.append(text_0_1_4_8_1);

    div_0_1_4.append(a_0_1_4_8);

    div_0_1.append(div_0_1_4);

    parent.append(div_0_1);
}
