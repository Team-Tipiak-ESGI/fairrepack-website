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

<script>
    const uuid = getPage().pageId;
    if (uuid !== undefined) {
        userVue.basicUserInfo(document.querySelector("div#userInfo"), document.querySelector("div#userProducts"), uuid);
    }

    userVue.updateAccountPage();
</script>

<?php include "includes/footer.php"; ?>