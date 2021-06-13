<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <!-- TODO: Display specification -->
        <h1><span data-i18n>php.reference.reference</span></h1>

        <div id="productList" class="d-flex flew-row flex-wrap justify-content-center"></div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </section>
</main>

<script>
    const productList = document.querySelector('div#productList');

    window.nav = pagination();
    window.nav.plugPaginationElement(document.querySelector("#pagination"), referenceVue.buildProductList, productList);
</script>

<?php include "includes/footer.php"; ?>