<?php include "includes/header.php"; ?>

<main class="container my-5">
        <div class="modal fade" id="modalPP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Privacy policy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>Collected data</h3>
                        <p><strong>Disclaimer:</strong> None of your data is used for commercial use!</p>
                        <ul>
                            <li>Email address</li>
                            <li>Login history which includes IP address, user agent and date of last login.</li>
                        </ul>

                        <h3>Stored data on your browser</h3>
                        <p><strong>Disclaimer:</strong> No cookies are used on this website! Everything is stored in your browser's cache.</p>
                        <ul>
                            <li>JWT session token</li>
                            <li>Your current shopping cart</li>
                        </ul>
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
                <p>Already having an account ? Please, sign in.</p>
                <form id="accountForm" class="needs-validation" novalidate onsubmit="return (UserController.login(this), false);">
                    <div class="mb-3">
                        <label class="d-block" for="loginEmail">Email</label>
                        <input id="loginEmail" name="email" type="email" class="form-control" autocomplete="email"
                               placeholder="example@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="d-block" for="loginPassword">Password</label>
                        <input id="loginPassword" name="password" type="password" class="form-control" minlength="8"
                               autocomplete="current-password" placeholder="Password" required>
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            Invalid email address or password.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="button" class="btn btn-danger" onclick="UserController.logout()">Logout</button>
                    <button type="button" class="btn btn-danger" onclick="UserController.remove()">Delete</button>
                </form>
            </div>

            <div class="d-flex flex-column">
                <p>New to Fair Repack ? We suggest you to sign up.</p>
                <form id="accountForm" class="needs-validation" novalidate onsubmit="return (UserController.signup(this), false);">
                    <div class="mb-3">
                        <label class="d-block" for="signupEmail">Email</label>
                        <input id="signupEmail" name="email" type="email" class="form-control" autocomplete="email"
                               placeholder="example@example.com" required>
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            Invalid email address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="d-block" for="signupPassword">Password</label>
                        <input id="signupPassword" name="password" type="password" class="form-control"
                               autocomplete="current-password" placeholder="Password" required minlength="8">
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            Password too short.
                        </div>
                    </div>

                    <p class="fw-lighter">
                        By signing up, you consent to our
                        <a class="text-decoration-none" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalPP">privacy policy</a>.
                    </p>
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </form>
            </div>

        </div>
    </section>

    <section>
        <h1>Your products</h1>
        <div id="userProducts" class="d-flex justify-content-center flex-wrap"></div>
    </section>
</main>

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