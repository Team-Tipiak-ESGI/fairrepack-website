<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <!-- TODO: Display product list -->

        <form id="addProductForm" onsubmit="return (productController.create(this), false)">
            <label class="d-block mb-3">
                Référence
                <select name="reference" class="form-select"></select>
            </label>

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

            <label class="d-block mb-3">
                Description
                <textarea name="description" class="form-control"></textarea>
            </label>

            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <div id="referenceList" class="d-flex flew-row flex-wrap justify-content-center"></div>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/controller/userController.js"></script>

<script src="public/scripts/model/referenceModel.js"></script>
<script src="public/scripts/vue/referenceVue.js"></script>

<script src="public/scripts/model/productModel.js"></script>
<script src="public/scripts/controller/productController.js"></script>

<script>
    referenceVue.buildReferenceList(document.querySelector("div#referenceList"));
    referenceVue.buildReferenceSelect(document.querySelector("form#addProductForm select[name=reference]"));
</script>

<?php include "includes/footer.php"; ?>