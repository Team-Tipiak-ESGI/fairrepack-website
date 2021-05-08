<?php include "includes/header.php"; ?>

<main class="container my-5">
    <section>
        <div id="cart" class="list-group"></div>
        <script src="https://js.stripe.com/v3/"></script>
        <button type="button" id="checkout-button" class="btn btn-primary mt-3">Checkout</button>
    </section>
</main>

<script src="public/scripts/controller/cartController.js"></script>
<script src="public/scripts/vue/cartVue.js"></script>
<script src="public/scripts/utils/utils.js"></script>

<script>
    cartVue.buildProductList(document.querySelector("#cart"));
</script>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51Iom4bHzfyqVGMdc9rN4v17lVPIkAXEhYikGGYLrFMTBhizlKMZqPGBRsZnuDy8oGlLCbAVBrnNGpGFIP0jczIPx00sMaZPVps");
    var checkoutButton = document.getElementById("checkout-button");
    checkoutButton.addEventListener("click", function () {
        fetch("/api/create-checkout-session.php", {
            method: "POST",
            body: window.localStorage.getItem("cart"),
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
                // If redirectToCheckout fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using error.message.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
    });
</script>

<?php include "includes/footer.php"; ?>