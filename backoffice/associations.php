<?php
include "../includes/header.php";?>

<?php
$page = "associations";
include "i.php";
?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add association</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAssociationForm" onsubmit="return (associationController.create(this), false);">
                        <label class="d-block mb-3">
                            Association name
                            <input name="name" class="form-control" placeholder="Name" required>
                        </label>

                        <label class="d-block mb-3">
                            Description
                            <textarea name="description" class="form-control" placeholder="Description"></textarea>
                        </label>

                        <label class="d-block mb-3">
                            Image
                            <input name="image" type="file" class="form-control" placeholder="Name">
                        </label>

                        <div class="mb-3">
                            <label for="address">Association address</label>
                            <select name="address" id="address" class="form-select"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addAssociationForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container my-5">
        <section class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h1>Associations</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add association
                </button>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="associationList"></tbody>
            </table>

            <ul class="pagination justify-content-center" id="pagination"></ul>
        </section>
    </main>

    <script>
        const associationList = document.querySelector("tbody#associationList");
        addressVue.buildAddressSelect(document.querySelector("form#addAssociationForm select[name=address]"));

        window.nav = pagination();
        window.nav.plugPaginationElement(document.querySelector("#pagination"), associationVue.buildAssociationList, associationList);
    </script>

<?php include "../includes/footer.php"; ?>