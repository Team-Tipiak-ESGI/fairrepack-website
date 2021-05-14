const cartVue = {};

cartVue.buildProductList = function(div = document.querySelector("#cart"), products = cartController.get()) {
    if (Object.keys(products).length === 0) {
        div.innerHTML = "<span>Your cart is empty, <a href='/references.php'>start shopping now!</a></span>";
        return;
    }

    for (const key in products) {
        if (products.hasOwnProperty(key)) {
            const reference = products[key];

            div.append(this.buildCartElement(key, reference))
        }
    }
}

cartVue.buildCartElement = function(uuid, product) {
    const li_1 = document.createElement(`li`);
    li_1.classList.add(`list-group-item`);
    const div_c = document.createElement(`div`);
    div_c.classList.add(`d-flex`, `w-100`, `justify-content-between`, `align-items-center`);
    const a_3e = document.createElement(`a`);
    a_3e.classList.add(`mb-1`, `h5`, `text-decoration-none`);
    a_3e.href = `/reference.php?id=${uuid}`;

    div_c.append(a_3e);
    a_3e.innerText = `${product.brand} ${product.name}`;

    li_1.append(div_c);
    const p_e = document.createElement(`p`);
    p_e.classList.add(`mb-1`);

    li_1.append(p_e);
    const value = parseFloat(product.offers[0].price);
    p_e.innerText = `${value} € × ${product.count} = ${(value * product.count).toFixed(2)} €`;
    const div_g = document.createElement(`div`);
    div_g.classList.add(`d-flex`, `align-items-center`);
    const text_4h = document.createTextNode(`Qté.`);
    div_g.append(text_4h);
    const input_4i = document.createElement(`input`);
    input_4i.type = `number`;
    input_4i.value = `${product.count}`;
    input_4i.min = `1`;
    input_4i.classList.add(`mx-2`, `form-control`, `form-control-sm`, `d-inline`);
    input_4i.style.width = `50px`;

    div_g.append(input_4i);
    const button_4k = document.createElement(`button`);
    button_4k.classList.add(`btn`, `btn-danger`, `btn-sm`);

    div_g.append(button_4k);
    button_4k.innerText = `Supprimer`;

    button_4k.addEventListener("click", (e) => {
        cartController.updateCount(uuid, 0);
        li_1.remove();
        cartVue.buildProductList();
    });

    li_1.append(div_g);

    input_4i.addEventListener("change", (e) => {
        const amount = e.target.value;
        const value = parseFloat(product.offers[0].price);
        cartController.updateCount(uuid, amount);
        p_e.innerText = `${value} € × ${amount} = ${(value * amount).toFixed(2)} €`;
    });

    return li_1;
}

cartVue.updateHeader = function() {
    document.getElementById("headerCart").innerHTML = cartController?.getTotal() ?? 0;
}