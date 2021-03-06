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
                <span data-i18n>php.index.daily_deals</span>
            </div>
            <br>
            <div>
            <div class="row" style="padding: 10px" ><!-- d??sol?? j'ai pas r??ussi ?? faire mieux, ??a marchait pas sinon :c -->
                <?php $bddResult = getProducts();
                foreach ($bddResult as $Product) {
                    $imgUrl = getProductsImageUrls($Product["uuid_product"]);
                    if (count($imgUrl) > 0) {
                        $imgUrl = $imgUrl[0];
                    } else {
                        $imgUrl = "/image/product/";
                    }
                    ?>
                    <div class="col">
                        <div class="card text-center h-100" style="width: 18rem;">
                            <img src="<?php echo $imgUrl;?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $Product['name'];?></h5>
                                <p class="card-text "><?php echo $Product['description'];?></p>
                            </div>
                            <div class="card-footer">
                                <a href="<?php echo 'product.php?id='.$Product['uuid_product'];?>" class="btn btn-primary"><span data-i18n>php.index.see_product</span></a>
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
    <section>
        <div>

        </div>
    </section>
</main>

<?php include "includes/footer.php"; ?>