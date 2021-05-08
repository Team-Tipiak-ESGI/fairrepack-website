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

    <section>
        <h1>Vos produits</h1>
        <div id="userProducts" class="d-flex justify-content-center flex-wrap"></div>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/vue/userVue.js"></script>
<script src="public/scripts/vue/productVue.js"></script>
<script src="public/scripts/controller/userController.js"></script>

<script>
    const uuid = getToken()?.payload.uuid;
    if (uuid !== undefined)
        userVue.buildProductDiv(document.querySelector("div#userProducts"), uuid);
</script>

<?php include "includes/footer.php"; ?>