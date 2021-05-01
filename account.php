<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <form id="accountForm">
            <label class="d-block mb-3">
                Email
                <input name="email" type="email" class="form-control">
            </label>
            <label class="d-block mb-3">
                Password
                <input name="password" type="password" class="form-control">
            </label>

            <button type="button" class="btn btn-primary" onclick="UserController.signup()">Signup</button>
            <button type="button" class="btn btn-primary" onclick="UserController.login()">Login</button>
            <button type="button" class="btn btn-danger" onclick="UserController.logout()">Logout</button>
            <button type="button" class="btn btn-danger" onclick="UserController.remove()">Delete</button>
        </form>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/controller/userController.js"></script>

<?php include "includes/footer.php"; ?>