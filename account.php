<?php include "includes/header.php"; ?>

<main class="container my-5">
        <div class="modal fade" id="modalPP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci consequatur delectus deleniti,
                            doloremque error eum illum in numquam optio qui quia quidem quo reprehenderit sint, totam voluptas voluptates voluptatum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ab assumenda distinctio doloremque error eveniet excepturi, exercitationem impedit inventore
                            ipsa maxime molestias nemo odio, odit, quo ratione reiciendis repellat tenetur! Ut.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci consequatur delectus deleniti,
                            doloremque error eum illum in numquam optio qui quia quidem quo reprehenderit sint, totam voluptas voluptates voluptatum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ab assumenda distinctio doloremque error eveniet excepturi, exercitationem impedit inventore
                            ipsa maxime molestias nemo odio, odit, quo ratione reiciendis repellat tenetur! Ut.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci consequatur delectus deleniti,
                            doloremque error eum illum in numquam optio qui quia quidem quo reprehenderit sint, totam voluptas voluptates voluptatum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ab assumenda distinctio doloremque error eveniet excepturi, exercitationem impedit inventore
                            ipsa maxime molestias nemo odio, odit, quo ratione reiciendis repellat tenetur! Ut.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci consequatur delectus deleniti,
                            doloremque error eum illum in numquam optio qui quia quidem quo reprehenderit sint, totam voluptas voluptates voluptatum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ab assumenda distinctio doloremque error eveniet excepturi, exercitationem impedit inventore
                            ipsa maxime molestias nemo odio, odit, quo ratione reiciendis repellat tenetur! Ut.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                    </div>
                </div>
            </div>
        </div>

    <section class="container">
        <div class="d-flex justify-content-around">
            <div class="d-flex flex-column">
                <p>Already Having an Account ? Please, Sign In.</p>
                <form id="accountForm" onsubmit="return (UserController.login(this), false);">
                    <label class="d-block mb-3">
                        Email
                        <input name="email" type="email" class="form-control" autocomplete="email" placeholder="example@example.com">
                    </label>
                    <label class="d-block mb-3">
                        Password
                        <input name="password" type="password" class="form-control" autocomplete="current-password" placeholder="Password">
                    </label>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="button" class="btn btn-danger" onclick="UserController.logout()">Logout</button>
                    <button type="button" class="btn btn-danger" onclick="UserController.remove()">Delete</button>
                </form>
            </div>
            <div class="d-flex flex-column">
                <p>New to Fair Repack ? We suggest you to sign up.</p><br>
                <form id="accountForm" onsubmit="return (UserController.signup(this), false);">
                    <label class="d-block mb-3">
                        Email
                        <input name="email" type="email" class="form-control" autocomplete="email" placeholder="example@example.com">
                    </label>
                    <label class="d-block mb-3">
                        Password
                        <input name="password" type="password" class="form-control" autocomplete="current-password" placeholder="Password">
                    </label>
                    <p class="fw-lighter">By signing up, you consent to our <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalPP">privacy policy</a></p>
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </form>
            </div>
        </div>
<!--
        <form id="accountForm">
            <label class="d-block mb-3">
                Email
                <input name="email" type="email" class="form-control" autocomplete="email" placeholder="example@example.com">
            </label>
            <label class="d-block mb-3">
                Password
                <input name="password" type="password" class="form-control" autocomplete="current-password" placeholder="Password">
            </label>

            <button type="button" class="btn btn-primary" onclick="UserController.signup()">Signup</button>
            <button type="button" class="btn btn-primary" onclick="UserController.login()">Login</button>
            <button type="button" class="btn btn-danger" onclick="UserController.logout()">Logout</button>
            <button type="button" class="btn btn-danger" onclick="UserController.remove()">Delete</button>
        </form>
        -->
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