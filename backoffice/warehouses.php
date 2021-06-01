<?php include "../includes/header.php"; ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addWarehouseForm" onsubmit="return (warehouseController.create(this), false);">
                        <label class="d-block mb-3">
                            Warehouse name
                            <input name="name" class="form-control" placeholder="Name" required>
                        </label>

                        <div class="mb-3">
                            <label for="address">Warehouse address</label>
                            <select name="address" id="address" class="form-select"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addWarehouseForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container my-5">
        <section class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h1>Warehouses</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add warehouse
                </button>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Postal code</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="warehouseList"></tbody>
            </table>

            <ul class="pagination justify-content-center" id="pagination"></ul>
        </section>
    </main>

    <script>
        const warehouseList = document.querySelector("tbody#warehouseList");
        addressVue.buildAddressSelect(document.querySelector("form#addWarehouseForm select[name=address]"));

        window.nav = pagination();
        window.nav.plugPaginationElement(document.querySelector("#pagination"), warehouseVue.buildWarehouseList, warehouseList);
    </script>

<?php include "../includes/footer.php"; ?>