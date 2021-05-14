<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FairRepack</title>

    <script src="public/scripts/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/styles/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
          crossorigin="anonymous">

    <link rel="icon" type="image/png" href="/public/assets/favicon_140.png">
    <script src="/public/scripts/utils/utils.js"></script>
</head>
<body class="min-vh-100 d-flex flex-column justify-content-between">
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
                            <a class="nav-link" href="/account.php">Account</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/references.php">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/cart.php">Cart</a>
                        </li>
                    </ul>
                    <form class="d-flex mb-0">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="z-index: 500;"></div>