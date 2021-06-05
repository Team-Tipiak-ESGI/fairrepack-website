<?php include "includes/header.php"; ?>

<div class="modal fade" id="colissimoModal" tabindex="-1" aria-labelledby="colissimoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="colissimoModalLabel">Colissimo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="colissimoForm" onsubmit="return (productController.update(this), false)">
                    <label for="colissimoInput" class="form-label">Colissimo voucher</label>
                    <input type="text" name="colissimo" class="form-control" id="colissimoInput" placeholder="ABCDEFG">
                    <button class="btn btn-primary w-100 d-none" id="getColissimoButton" type="button" onclick="productVue.getColissimo();">Get Colissimo voucher</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="colissimoForm" id="colissimoSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<main class="container my-5">
    <div class="row justify-content-center align-items-center">
        <section class="col-md-4 col-12">
            <div id="productInfo"></div>
            <div id="productControls" class="d-flex flex-row">
                <button class="btn btn-secondary my-1 d-none" id="addToCard" type="button" onclick="cartController.addProduct(getPage().pageId);">
                    <!-- Button visible by user after product is accepted -->
                    Add to cart
                </button>
                <button class="btn btn-success my-1 d-none" id="acceptLastOffer" type="button" onclick="productController.updateState('accepted');">
                    <!-- Button visible by [not last offer's user] -->
                    Accept
                </button>
                <button class="btn btn-danger my-1" id="declineLastOffer" type="button" onclick="productController.updateState('rejected');">
                    <!-- Button visible by owner and admin -->
                    Reject
                </button>
                <button class="btn btn-primary my-1 d-none" id="getColissimo" type="button" data-bs-toggle="modal" data-bs-target="#colissimoModal">
                    <!-- Button visible by user after product is accepted -->
                    Colissimo
                </button>
            </div>
        </section>

        <section class="col-md-8 col-12">
            <h1>Offers</h1>

            <form id="addOfferForm" class="d-none" onsubmit="return (offerController.create(this), false)">
                <label for="price">Price</label>
                <input class="form-control my-1" id="price" type="number" min="0" name="price" value="0" placeholder="Price">
                <label for="note">Description</label>
                <textarea class="form-control my-1" id="note" name="note" placeholder="Description"></textarea>
                <button class="btn btn-primary my-1" type="submit">Faire une offre</button>
            </form>

            <div id="offers"></div>
        </section>
    </div>
</main>

<script>
    productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'), document.querySelector('div#images'));
</script>

<script type="module" src="/public/scripts/chest.module.js"></script>

<?php include "includes/footer.php"; ?>