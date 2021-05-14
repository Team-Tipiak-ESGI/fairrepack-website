<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <!-- TODO: Display specification -->
        <h1>Référence</h1>
        <form id="buyForm" onsubmit="return (false);">
            <label class="d-block mb-3">
                Etat
                <select name="quality" class="form-select">
                    <option value="new">Neuf</option>
                    <option value="high">Bonne</option>
                    <option value="medium">Moyenne</option>
                    <option value="low">Faible</option>
                    <option value="broken">Cassé</option>
                </select>
            </label>

            <button type="submit" class="btn btn-primary">Acheter</button>
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