const cartVue = {};

cartVue.buildProductList = function(div, cart = cartController.get()) {
    for (const key in cart) {
        if (cart.hasOwnProperty(key)) {
            const reference = cart[key];

            div.append(this.buildCartElement(key, reference))
        }
    }
}

cartVue.buildCartElement = function(uuid, reference) {
    const li_1 = document.createElement(`li`);
    li_1.classList.add(`list-group-item`);
    const div_c = document.createElement(`div`);
    div_c.classList.add(`d-flex`, `w-100`, `justify-content-between`, `align-items-center`);
    const a_3e = document.createElement(`a`);
    a_3e.classList.add(`mb-1`, `h5`, `text-decoration-none`);
    a_3e.href = `/reference.php?id=${uuid}`;

    div_c.append(a_3e);
    a_3e.innerText = `${reference.brand} ${reference.name}`;

    li_1.append(div_c);
    const p_e = document.createElement(`p`);
    p_e.classList.add(`mb-1`);

    li_1.append(p_e);
    p_e.innerText = `${reference.value} € × ${reference.count} = ${reference.value * reference.count} €`;
    const div_g = document.createElement(`div`);
    div_g.classList.add(`d-flex`, `align-items-center`);
    const text_4h = document.createTextNode(`Qté.`);
    div_g.append(text_4h);
    const input_4i = document.createElement(`input`);
    input_4i.type = `number`;
    input_4i.value = `${reference.count}`;
    input_4i.min = `1`;
    input_4i.classList.add(`mx-2`, `form-control`, `form-control-sm`, `d-inline`);
    input_4i.style.width = `50px`;

    div_g.append(input_4i);
    const button_4k = document.createElement(`button`);
    button_4k.classList.add(`btn`, `btn-danger`, `btn-sm`);

    div_g.append(button_4k);
    button_4k.innerText = `Supprimer`;

    li_1.append(div_g);

    input_4i.addEventListener("change", (e) => {
        const value = e.target.value;
        cartController.updateCount(uuid, value);
        p_e.innerText = `${reference.value} € × ${value} = ${reference.value * value} €`;
    });

    return li_1;
}
