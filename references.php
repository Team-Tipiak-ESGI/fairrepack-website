<?php include "includes/header.php"; ?>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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

                    <span>Images</span>
                    <div class="d-flex mb-3">
                        <button class="btn btn-primary" id="addImage">+</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addProductForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<main class="container my-5">
    <section class="container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
            Add product
        </button>
        <p></p>
        <div class="d-flex">
            <!-- div verticale pour filtres -->
            <div class="d-flex flex-column">
                <!-- div pour filtres  prix -->
                <p class=" fs-6 fw-lighter text-muted">Filtre par prix</p>
                <div class="d-flex flex-row">
                    <input class="form-control form-control-sm" type="number" placeholder="prix minimum">
                    <input class="form-control form-control-sm" type="number" placeholder="prix maximum">
                </div>
                <p></p>
                <!-- div pour filtres marques, checkbox -->
                <div class="d-flex flex-column">
                    <p class=" fs-6 fw-lighter text-muted">Filtre par marques</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkBrand1">
                        <label class="form-check-label" for="checkBrand1">Apple</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkBrand2">
                        <label class="form-check-label" for="checkBrand2">Samsung</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkBrand3">
                        <label class="form-check-label" for="checkBrand3">Huawei</label>
                    </div>
                </div>
                <p></p>
                <!-- div pour filtres annee, checkbox -->
                <div class="d-flex flex-column">
                    <p class=" fs-6 fw-lighter text-muted">Filtre par annee</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAnnee2019">
                        <label class="form-check-label" for="checkAnnee2019">2019</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAnnee2020">
                        <label class="form-check-label" for="checkAnnee2020">2020</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAnnee2021">
                        <label class="form-check-label" for="checkAnnee2021">2021</label>
                    </div>
                </div>
            </div>
            <!-- div verticale pour les produits -->
            <div class="d-flex flex-column">
                <div id="referenceList" class="d-flex flew-row flex-wrap justify-content-center"></div>
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/controller/userController.js"></script>

<script src="public/scripts/model/referenceModel.js"></script>
<script src="public/scripts/vue/referenceVue.js"></script>

<script src="public/scripts/model/productModel.js"></script>
<script src="public/scripts/controller/productController.js"></script>
<script src="public/scripts/vue/pagination.js"></script>
<script src="public/scripts/controller/cartController.js"></script>

<script>
    const referenceList = document.querySelector("div#referenceList");
    referenceVue.buildReferenceSelect(document.querySelector("form#addProductForm select[name=reference]"));

    window.nav = pagination();
    window.nav.plugPaginationElement(document.querySelector("#pagination"), referenceVue.buildReferenceList, referenceList);
</script>

<?php include "includes/footer.php"; ?>