<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <?php include "seo.php"; ?>

    <script src="/public/scripts/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/styles/bootstrap.min.css">

    <link rel="icon" type="image/png" href="/public/assets/favicon_140.png">
</head>
<body class="min-vh-100 d-flex flex-column justify-content-between">

    <script src="/public/scripts/utils/utils.js"></script>
    <script src="/public/scripts/model/productModel.js"></script>
    <script src="/public/scripts/model/referenceModel.js"></script>
    <script src="/public/scripts/model/userModel.js"></script>

    <script src="/public/scripts/controller/cartController.js"></script>
    <script src="/public/scripts/controller/offerController.js"></script>
    <script src="/public/scripts/controller/productController.js"></script>
    <script src="/public/scripts/controller/userController.js"></script>

    <script src="/public/scripts/vue/cartVue.js"></script>
    <script src="/public/scripts/vue/productVue.js"></script>
    <script src="/public/scripts/vue/referenceVue.js"></script>
    <script src="/public/scripts/vue/userVue.js"></script>
    <script src="/public/scripts/vue/pagination.js"></script>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/public/assets/favicon_140.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                    Fair Repack
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/account.php" id="headerAccount">Account</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/references.php">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="/cart.php">
                                Cart
                                <span class="badge rounded-pill bg-primary ms-1" id="headerCart">0</span>
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex mb-0" id="searchForm">
                        <input class="form-control me-2" id="searchBar" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="z-index: 500;"></div>