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
                        <p><strong><span data-i18n>php.variables.disclaimer</span></strong><span data-i18n>php.account.no_data_used</span>
                        </p>
                        <ul>
                            <li><span data-i18n>php.account.email_address</span></li>
                            <li><span data-i18n>php.account.login_history</span></li>
                        </ul>

                        <h3><span data-i18n>php.account.stored_datas</span></h3>
                        <p><strong><span data-i18n>php.variables.disclaimer</span></strong><span data-i18n>php.account.no_cookies</span>
                        </p>
                        <ul>
                            <li><span data-i18n>php.account.jwt_session_token</span></li>
                            <li><span data-i18n>php.account.current_shopping_cart</span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><span data-i18n>php.account.understood</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <section class="container" id="signedOut">
            <div class="d-flex justify-content-around">

                <div class="d-flex flex-column">
                    <p><span data-i18n>php.account.already_account</span></p>
                    <form id="accountForm" class="needs-validation" novalidate
                          onsubmit="return (UserController.login(this), false);">
                        <div class="mb-3">
                            <label class="d-block" for="loginEmail">Email</label>
                            <input id="loginEmail" name="email" type="email" class="form-control" autocomplete="email"
                                   placeholder="example@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="d-block" for="loginPassword"><span
                                        data-i18n>php.variables.password</span></label>
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
                    <form id="accountForm" class="needs-validation" novalidate
                          onsubmit="return (UserController.signup(this), false);">
                        <div class="mb-3">
                            <label class="d-block" for="signupEmail">Email</label>
                            <input id="signupEmail" name="email" type="email" class="form-control" autocomplete="email"
                                   placeholder="example@example.com" required>
                            <div id="validationLoginFeedback" class="invalid-feedback">
                                <span data-i18n>php.account.invalid_email</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="d-block" for="signupPassword"><span
                                        data-i18n>php.variables.password</span></label>
                            <input id="signupPassword" name="password" type="password" class="form-control"
                                   autocomplete="current-password" placeholder="Password" required minlength="8">
                            <div id="validationLoginFeedback" class="invalid-feedback">
                                <span data-i18n>php.account.pwd_too_short</span>
                            </div>
                        </div>

                        <p class="fw-lighter">
                            <span data-i18n>php.account.by_signing_in</span>
                            <a class="text-decoration-none" style="cursor:pointer;" data-bs-toggle="modal"
                               data-bs-target="#modalPP"><span data-i18n>php.account.privacy_policy</span></a>.
                        </p>
                        <button type="submit" class="btn btn-primary"><span data-i18n>php.variables.sign_up</span>
                        </button>
                    </form>
                </div>

            </div>
        </section>

        <section class="d-none" id="signedIn">

            <h1><span data-i18n>php.account.modify_personal_info</span></h1>
            <h4><span data-i18n>php.account.let_empty</span></h4>
            <br>

            <form id="updateAccountForm" class="needs-validation" novalidate
                  onsubmit="return (UserController.update(this), false)">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" data-name="email"
                               placeholder="example@example.com">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputusername"><span data-i18n>php.account.username</span></label>
                        <input type="text" class="form-control" id="inputUsername" name="username" data-name="username"
                               placeholder="Manu75">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword"><span data-i18n>php.account.last_pwd</span></label>
                        <input type="lastpassword" class="form-control" id="lastPassword" name="lastpwd"
                               placeholder="Enter your current password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="newPassword"><span data-i18n>php.account.new_pwd</span></label>
                        <input type="password" class="form-control" id="newPassword" name="newpwd"
                               placeholder="Enter new password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="confirmPassword"><span data-i18n>php.account.confirm_new_pwd</span></label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmpwd"
                               placeholder="Confirm new password">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="phone"><span data-i18n>php.account.phone_number</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" data-name="phone"
                               placeholder="01 23 45 67 89">
                    </div>
                    <div class="form-group col-md-9"></div>
                </div>
                <br>
                <h5><span data-i18n>php.account.address</span></h5>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="Country"><span data-i18n>php.account.country</span></label>
                        <input type="text" class="form-control" id="country" name="country" data-name="state"
                               placeholder="France">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="zipcode"><span data-i18n>php.account.zip_code</span></label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" data-name="postal_code"
                               placeholder="75008">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="city"><span data-i18n>php.account.city</span></label>
                        <input type="text" class="form-control" id="city" name="city" data-name="city"
                               placeholder="Paris">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="Address"><span data-i18n>php.account.address</span> </label>
                        <input type="text" class="form-control" id="Address" name="address" data-name="address_line1"
                               placeholder="55 Rue du Faubourg Saint-Honoré">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="owner_name"><span data-i18n>php.account.owner_name</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" data-name="owner_name"
                               placeholder="Emmanuel Macron">
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="add_infos"><span data-i18n>php.account.supinfo</span></label>
                        <textarea type="text" class="form-control" id="add_infos" name="add_infos" data-name="additional_info"
                                  placeholder="Le palais de l'Élysée, dit l'Élysée, est un ancien hôtel particulier parisien, situé au nᵒ 55 de la rue du Faubourg-Saint-Honoré, dans le 8ᵉ arrondissement de Paris. Il est le siège de la présidence de la République française et la résidence officielle du chef de l'État depuis la IIᵉ République." rows="5"></textarea>
                    </div>

                </div>
                <br>
                <br>
                <button type="submit" class="btn btn-primary"><span data-i18n>php.account.update_informations</span></button>
                <button type="button" class="btn btn-danger" onclick="UserController.remove()"><span data-i18n>php.account.delete_ur_acc</span>
                </button>
                <button type="button" class="btn btn-danger" onclick="UserController.logout()"><span data-i18n>php.account.logout</span>
                </button>
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

        userVue.updateAccountPage(uuid);
    </script>

<?php include "includes/footer.php"; ?>