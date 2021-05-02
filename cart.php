<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section>
        <div id="cart"></div>
    </section>
</main>


<script src="public/scripts/controller/cartController.js"></script>
<script src="public/scripts/vue/cartVue.js"></script>

<script>
    cartVue.buildProductList(document.querySelector("#cart"));
</script>

<?php include "includes/footer.php"; ?>