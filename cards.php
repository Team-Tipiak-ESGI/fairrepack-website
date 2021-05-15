<?php include "includes/header.php"; ?>
<div class="container-md">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">$Produit</h5>
        </div>
        <div id="carouselCard" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="public/assets/sad.png" class="d-block img-thumbnail card-img-top">
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="public/assets/ELr5LshXYAIOwvt.jpg" class="d-block img-thumbnail card-img-top">
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <img src="public/assets/giggle.gif" class="d-block img-thumbnail card-img-top">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCard" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselCard" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item card-text">Quality : $qual</li>
                <li class="list-group-item card-text">Price : $price</li>
                <li class="list-group-item card-text">State: $state</li>
                <li class="list-group-item card-text">Seller: <a href="/user.php?id=${product.user}">Seller</a></li>
            </ul>
        </div>
        <div class="card-footer text-muted">
            Added : $date
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>

<script>
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






const div_0_1 = document.createElement(`div`);
div_0_1.classList.add(`card`);
const div_0_1_2 = document.createElement(`div`);
div_0_1_2.classList.add(`card-header`);
const h5_0_1_2_2 = document.createElement(`h5`);
h5_0_1_2_2.classList.add(`card-title`);
const text_0_1_2_2_1 = document.createTextNode(`Produit :`);
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
const div_0_1_4_2_2 = document.createElement(`div`);
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

div_0_1_4_2.append(div_0_1_4_2_6);

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

ul_0_1_6_2.append(li_0_1_6_2_8);

div_0_1_6.append(ul_0_1_6_2);

div_0_1.append(div_0_1_6);
const div_0_1_8 = document.createElement(`div`);
div_0_1_8.classList.add(`card-footer`, `text-muted`);
const text_0_1_8_1 = document.createTextNode(`Added : ${new Date(product.created).format("%dd/%MM/%yyyy à %hh:%mm")}`);
div_0_1_8.append(text_0_1_8_1);

div_0_1.append(div_0_1_8);

parent.append(div_0_1);




</script>

























