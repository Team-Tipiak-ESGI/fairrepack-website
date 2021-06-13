<?php include "includes/header.php";
require_once "utils/database.php";
require_once "utils/dao/product.php";?>


<main class="container my-5">
    <section>
        <div id="carousel-land-page" class="carousel slide" data-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-land-page" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel-land-page" data-bs-slide-to="1" aria-label="Slide 2"></button>
               <!-- <button type="button" data-bs-target="#carousel-land-page" data-bs-slide-to="2" aria-label="Slide 3"></button>-->
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="./public/models/Banner1.png">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./public/models/Banner2.png">
                </div>
  <!--              <div class="carousel-item">
                    <img class="d-block w-100" src="./public/assets/carousel/carousel3.png">
                </div>-->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-land-page" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><span data-i18n>php.variables.prev_page</span></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-land-page" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><span data-i18n>php.variables.next_page</span></span>
            </button>
        </div>
    </section>
    <br> <br>
    <section>
        <div class="card text-center">
            <div class="card-header">
                php.index.daily_deals
            </div>
            <br>
            <div>
            <div class="row" style="padding: 10px" ><!-- désolé j'ai pas réussi à faire mieux, ça marchait pas sinon :c -->
                <?php $bddResult = getProducts();
                for ($i=0; $i < 4; $i++) {
                    $imgUrl = getProductsImageUrls($bddResult[$i]["uuid_product"]);
                    if (count($imgUrl) > 0) {
                        $imgUrl = $imgUrl[0];
                    } else {
                        $imgUrl = "/image/product/";
                    }
                    ?>
                    <div class="col padding-dernieres-sorties">
                        <div class="card text-center h-100" style="width: 18rem;">
                            <img src="<?php echo $imgUrl;?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $bddResult[$i]['name'];?></h5>
                                <p class="card-text"><?php echo $bddResult[$i]['description'];?></p>
                                <a href="<?php echo 'product.php?id='.$bddResult[$i]['uuid_product'];?>" class="btn btn-primary">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            </div>
        </div>
    </section>
<br><br>
    <!--<section>
        <div class="row">
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <img src="public/assets/bonnetExample.png" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Super Bonnet <br> Hors de son Temps</h5>
                        <p class="card-text">Ce super bonnet cheap et classe permettra d'ajouter un peu de noel autour de vous.</p>
                        <a href="#" class="btn btn-primary">Acheter</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <img src="public/assets/bonnetExample.png" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Super Bonnet <br> Hors de son Temps</h5>
                        <p class="card-text">Ce super bonnet cheap et classe permettra d'ajouter un peu de noel autour de vous.</p>
                        <a href="#" class="btn btn-primary">Acheter</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <img src="public/assets/bonnetExample.png" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Super Bonnet <br> Hors de son Temps</h5>
                        <p class="card-text">Ce super bonnet cheap et classe permettra d'ajouter un peu de noel autour de vous.</p>
                        <a href="#" class="btn btn-primary">Acheter</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <img src="public/assets/bonnetExample.png" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Super Bonnet <br> Hors de son Temps</h5>
                        <p class="card-text">Ce super bonnet cheap et classe permettra d'ajouter un peu de noel autour de vous.</p>
                        <a href="#" class="btn btn-primary">Acheter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>-->

    <section>
        <div>

        </div>
    </section>
</main>

<?php include "includes/footer.php"; ?>