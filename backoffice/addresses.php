<?php
include "../includes/header.php";?>

<?php
$page = "addresses";
include "i.php";
?>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAddressForm" onsubmit="return (addressController.create(this), false);">
                        <label class="d-block mb-3">
                            Country
                            <input name="country" class="form-control" placeholder="Country" required>
                        </label>
                        <label class="d-block mb-3">
                            Owner name
                            <input name="name" class="form-control" placeholder="Owner name" required>
                        </label>
                        <label class="d-block mb-3">
                            Line 1
                            <input name="address_line1" class="form-control" placeholder="Line 1" required>
                        </label>
                        <label class="d-block mb-3">
                            Line 2
                            <input name="address_line2" class="form-control" placeholder="Line 2">
                        </label>
                        <label class="d-block mb-3">
                            City
                            <input name="city" class="form-control" placeholder="City" required>
                        </label>
                        <label class="d-block mb-3">
                            State
                            <input name="state" class="form-control" placeholder="State" required>
                        </label>
                        <label class="d-block mb-3">
                            Postal code
                            <input name="postal_code" class="form-control" placeholder="Postal code" required>
                        </label>
                        <label class="d-block mb-3">
                            Phone number
                            <input name="phone_number" class="form-control" placeholder="Phone number">
                        </label>
                        <label class="d-block mb-3">
                            Additional information
                            <textarea name="additional_info" class="form-control" placeholder="Additional information"></textarea>
                        </label>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addAddressForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container my-5">
        <section class="container">
            <div class="d-flex align-items-center justify-content-between">
                <h1>Addresses</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add address
                </button>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Country</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Line 1</th>
                    <th scope="col">Line 2</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Postal code</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Additional info</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="addressList"></tbody>
            </table>

            <ul class="pagination justify-content-center" id="pagination"></ul>
        </section>
    </main>

    <script>
        const addressList = document.querySelector("tbody#addressList");

        window.nav = pagination();
        window.nav.plugPaginationElement(document.querySelector("#pagination"), addressVue.buildAddressList, addressList);
    </script>

<?php include "../includes/footer.php"; ?>