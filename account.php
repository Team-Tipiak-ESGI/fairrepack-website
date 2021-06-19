<?php include "includes/header.php"; ?>

<main class="container my-5">
        <div class="modal fade" id="modalPP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span data-i18n>php.account.privacy_policy</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3><span data-i18n>php.account.collected_data</span></h3>
                        <p><strong><span data-i18n>php.variables.disclaimer</span></strong><span data-i18n>php.account.no_data_used</span></p>
                        <ul>
                            <li><span data-i18n>php.account.email_address</span></li>
                            <li><span data-i18n>php.account.login_history</span></li>
                        </ul>

                        <h3><span data-i18n>php.account.stored_datas</span></h3>
                        <p><strong><span data-i18n>php.variables.disclaimer</span></strong><span data-i18n>php.account.no_cookies</span></p>
                        <ul>
                            <li><span data-i18n>php.account.jwt_session_token</span></li>
                            <li><span data-i18n>php.account.current_shopping_cart</span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><span data-i18n>php.account.understood</span></button>
                    </div>
                </div>
            </div>
        </div>

    <section class="container" id="signedOut">
        <div class="d-flex justify-content-around">

            <div class="d-flex flex-column">
                <p><span data-i18n>php.account.already_account</span></p>
                <form id="accountForm" class="needs-validation" novalidate onsubmit="return (UserController.login(this), false);">
                    <div class="mb-3">
                        <label class="d-block" for="loginEmail">Email</label>
                        <input id="loginEmail" name="email" type="email" class="form-control" autocomplete="email"
                               placeholder="example@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="d-block" for="loginPassword"><span data-i18n>php.variables.password</span></label>
                        <input id="loginPassword" name="password" type="password" class="form-control" minlength="8"
                               autocomplete="current-password" placeholder="Password" required>
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            <span data-i18n>php.account.invalid_pwd</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><span data-i18n>php.account.login</span></button>
                </form>
            </div>

            <div class="d-flex flex-column">
                <p><span data-i18n>php.account.new_on_fairrepack</span></p>
                <form id="accountForm" class="needs-validation" novalidate onsubmit="return (UserController.signup(this), false);">
                    <div class="mb-3">
                        <label class="d-block" for="signupEmail">Email</label>
                        <input id="signupEmail" name="email" type="email" class="form-control" autocomplete="email"
                               placeholder="example@example.com" required>
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            <span data-i18n>php.account.invalid_email</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="d-block" for="signupPassword"><span data-i18n>php.variables.password</span></label>
                        <input id="signupPassword" name="password" type="password" class="form-control"
                               autocomplete="current-password" placeholder="Password" required minlength="8">
                        <div id="validationLoginFeedback" class="invalid-feedback">
                            <span data-i18n>php.account.pwd_too_short</span>
                        </div>
                    </div>

                    <p class="fw-lighter">
                        <span data-i18n>php.account.by_signing_in</span>
                        <a class="text-decoration-none" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalPP"><span data-i18n>php.account.privacy_policy</span></a>.
                    </p>
                    <button type="submit" class="btn btn-primary"><span data-i18n>php.variables.sign_up</span></button>
                </form>
            </div>

        </div>
    </section>

    <section class="d-none" id="signedIn">

        <h1>Modifiez vos informations personnelles</h1>
        <h4>Laisser vide si pas de changement</h4>
        <br>

        <form id="updateAccountForm" class="needs-validation" novalidate onsubmit="return (UserController.update(this), false)">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="insérer contenu de la bdd">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputusername">Nom d'utilisateur</label>
                        <input type="email" class="form-control" id="inputUsername" name="username" placeholder="insérer contenu de la bdd OU Vide si ça l'est">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword">Entrer votre ancien mot de passe</label>
                        <input type="lastpassword" class="form-control" id="lastPassword" name="lastpwd" placeholder="Enter last Password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="newPassword">Entrer votre nouveau de passe</label>
                        <input type="password" class="form-control" id="newPassword" name="newpwd" placeholder="Enter new Password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="confirmPassword">Confirmer votre nouveau mot de passe</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmpwd" placeholder="Confirm new Password">
                    </div>
                </div>

             <div class="form-group">
                    <label for="inputAddress">Adresse Complète</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="insérer contenu de la bdd">
                </div>
            <br>
            <br>
            <button type="submit" class="btn btn-primary">Mettre à jour vos informations</button>
            <button type="button" class="btn btn-danger" onclick="UserController.remove()"><span data-i18n>php.account.delete_ur_acc</span></button>
            <button type="button" class="btn btn-danger" onclick="UserController.logout()"><span data-i18n>php.account.logout</span></button>
        </form>
        <br>
        <br>
        <h1><span data-i18n>php.variables.your_products</span></h1>
        <div id="userProducts" class="d-flex justify-content-center flex-wrap"></div>
    </section>
</main>

<script>
    const uuid = getToken()?.payload?.uuid;
    if (uuid !== undefined) {
        userVue.buildProductDiv(document.querySelector("div#userProducts"), uuid);
    }

    userVue.updateAccountPage();
</script>

<?php include "includes/footer.php"; ?>