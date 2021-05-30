<?php include "../includes/header.php"; ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTypeForm" onsubmit="return (typeController.create(this), false);">
                        <label class="d-block mb-3">
                            Type name
                            <input name="name" class="form-control" placeholder="Name" required>
                        </label>

                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-select"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addTypeForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container my-5">
        <section class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h1>Types</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add type
                </button>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Name</th>
                </tr>
                </thead>
                <tbody id="typeList"></tbody>
            </table>

            <ul class="pagination justify-content-center" id="pagination"></ul>
        </section>
    </main>

    <script>
        const typeList = document.querySelector("tbody#typeList");
        typeVue.buildCategorySelect(document.querySelector("form#addTypeForm select[name=category]"));

        window.nav = pagination();
        window.nav.plugPaginationElement(document.querySelector("#pagination"), typeVue.buildTypeList, typeList);
    </script>

<?php include "../includes/footer.php"; ?>