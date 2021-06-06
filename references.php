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
                <form id="addProductForm">
                    <label class="d-block mb-3">
                        Reference
                        <select name="reference" class="form-select"></select>
                    </label>

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

                    <label class="d-block mb-3">
                        Description
                        <textarea name="description" class="form-control"></textarea>
                    </label>

                    <span>Images</span>
                    <div class="d-flex flex-column mb-3">
                        <button class="btn btn-primary" type="button" id="addImage" onclick="productVue.addImageField(this);">+</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><span data-i18n>php.variables.close</span></button>
                <button type="submit" form="addProductForm" class="btn btn-primary"><span data-i18n>php.variables.save</span></button>
            </div>
        </div>
    </div>
</div>

<main class="container my-5">
    <section class="container">
        <div class="d-flex justify-content-between align-items-center">
            <p class="fs-2" id="searchName"><span data-i18n>php.references.display_results</span></p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                <span data-i18n>php.references.add_product</span>
            </button>
        </div>
        <div class="row">
            <!-- div verticale pour filtres -->
            <div class="col-0 col-md-4 col-lg-2 d-flex flex-column">
                <label for="pageSize" class="fs-6 fw-lighter text-muted"><span data-i18n>php.references.page_size</span></label>
                <input type="number" placeholder="Page size" class="form-control form-control-sm mb-3" id="pageSize" min="5" max="100" step="5">
                <!-- div pour filtres prix -->
                <label class="fs-6 fw-lighter text-muted"><span data-i18n>php.references.price_filter</span></label>
                <div class="d-flex mb-3">
                    <input class="form-control form-control-sm me-2" type="number" placeholder="Min" min="0" max="9999">
                    <input class="form-control form-control-sm ms-2" type="number" placeholder="Max" min="0" max="9999">
                </div>
                <!-- div pour filtres marques, checkbox -->
                <div class="d-flex flex-column mb-3">
                    <label class="fs-6 fw-lighter text-muted"><span data-i18n>php.references.brand_filter</span></label>
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
                <!-- div pour filtres annee, checkbox -->
                <div class="d-flex flex-column mb-3">
                    <p class="fs-6 fw-lighter text-muted"><span data-i18n>php.references.year_filter</span></p>
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
            <div class="col-12 col-md-8 col-lg-10 d-flex flex-column">
                <div id="referenceList" class="d-flex flew-row flex-wrap justify-content-center"></div>
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </div>
        </div>
    </section>
</main>

<script>
    const referenceList = document.querySelector("div#referenceList");
    referenceVue.buildReferenceSelect(document.querySelector("form#addProductForm select[name=reference]"));

    window.nav = pagination();
    window.nav.plugPaginationElement(document.querySelector("#pagination"), referenceVue.buildReferenceList, referenceList);

    document.getElementById("addProductForm").addEventListener("submit", productController.create);

    getPage().setPageInput(document.getElementById("pageSize"));
</script>

<?php include "includes/footer.php"; ?>