<?php include "includes/header.php"; ?>

<main class="container my-5">
    <div class="row justify-content-center align-items-center">
        <section class="col-md-4 col-12">
            <div id="productInfo" class="col-12 col-lg-10"></div>
            <div id="productControls" class="col-12 col-lg-2 d-flex flex-row">
                <button class="btn btn-success my-1 d-none" id="acceptLastOffer" type="button" onclick="productController.updateState('accepted');">
                    <!-- Button visible by [not last offer's user] -->
                    Accepter
                </button>
                <button class="btn btn-danger my-1" id="declineLastOffer" type="button" onclick="productController.updateState('rejected');">
                    <!-- Button visible by owner and admin -->
                    Décliner
                </button>
                <button class="btn btn-primary my-1 d-none" id="getColissimo" type="button" onclick="productVue.getColissimo();">
                    <!-- Button visible by user after product is accepted -->
                    Colissimo
                </button>
            </div>
        </section>

        <section class="col-md-8 col-12">
            <h1>Offres</h1>

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

<?php include "includes/footer.php"; ?>