<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section class="container">
        <!-- TODO: Display user information -->
        <h1>Informations</h1>
        <div id="userInfo"></div>

        <h1>Produits</h1>
        <div id="userProducts" class="d-flex justify-content-center flex-wrap"></div>
    </section>
</main>

<script src="public/scripts/utils/utils.js"></script>
<script src="public/scripts/model/userModel.js"></script>
<script src="public/scripts/controller/userController.js"></script>

<script src="public/scripts/vue/productVue.js"></script>
<script src="public/scripts/vue/userVue.js"></script>

<?php include "includes/footer.php"; ?>