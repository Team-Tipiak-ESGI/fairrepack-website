<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <div id="productInfo"></div>
        <!-- TODO: Display product information -->
    </section>

    <section class="container">
        <h1>Offres</h1>

        <form id="addOfferForm" onsubmit="return (offerController.create(this), false)">
            <input class="form-control" type="number" min="0" name="price" value="0">
            <textarea class="form-control" name="note"></textarea>
            <button class="btn btn-primary" type="submit">Faire une offre</button>
        </form>

        <!-- TODO: List offers -->
        <div id="offers"></div>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/controller/userController.js"></script>
<script src="public/scripts/controller/offerController.js"></script>
<script src="public/scripts/vue/productVue.js"></script>
<script>
    productVue.buildProductPage(document.querySelector('div#productInfo'), document.querySelector('div#offers'));
</script>

<?php include "includes/footer.php"; ?>