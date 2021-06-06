<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <!-- TODO: Display specification -->
        <h1><span data-i18n>php.reference.reference</span></h1>
        <form id="buyForm" onsubmit="return (false);">
            <label class="d-block mb-3">
                <span data-i18n>php.reference.product_condition</span>
                <select name="quality" class="form-select">
                    <option value="new"><span data-i18n>php.reference.new</span></option>
                    <option value="high"><span data-i18n>php.reference.nearly_new</span></option>
                    <option value="medium"><span data-i18n>php.reference.good</span></option>
                    <option value="low"><span data-i18n>php.reference.damaged</span></option>
                    <option value="broken"><span data-i18n>php.reference.broken</span></option>
                </select>
            </label>

            <button type="submit" class="btn btn-primary"><span data-i18n>php.reference.buy</span></button>
        </form>

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