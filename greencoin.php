<?php include "includes/header.php";
require_once "utils/database.php";
require_once "utils/UUIDv4.php";
require_once "utils/Token.php";
require_once "utils/user.php";
require_once "utils/dao/user.php";
require_once "utils/dao/association.php";

$associations = getAssociations();

?>

    <main class="container my-5">
        <section class="container">
            <div class="card row text-center">
                <div class="card-header">
                    <nav>
                        <div class="nav nav-tabs nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Le Greencoin
                            </button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                    aria-selected="false">Téléchargement
                            </button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Votre solde GC
                            </button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="card-body">
                                <h5 class="card-title">Qu'est-ce que le <b>GreenCoin</b> ?</h5>
                                <img src="\public\models\greencoin2.png" class="card-img-top"
                                     style="height: 150px;width: 150px;">
                                <p class="card-text">Le <b>GreenCoin</b> est une monnaie virtuelle obtenue en faisant
                                    différents
                                    achats sur le site.<br>
                                    le <b>GreenCoin</b> représente un montant de <b>1$</b>, et sera obtenu tous les
                                    <b>10$</b> d'achats.<br>
                                    Voyez le <b>GreenCoin</b> comme des points de fidélité, que vous pouvez ensuite
                                    répartir
                                    et
                                    donner à différentes associations.<br>
                                    <br>Fair repack s'engage à verser le montant de <b>GreenCoins</b> selectionné en
                                    dollars,
                                    et ce à l'association que vous aurez choisie.<br>
                                    Vous retrouverez la liste des associations acceptant les <b>GreenCoins</b>
                                    ci-dessous.<br><br>
                                    lorsque vous aurez fait votre choix, rendez vous sur l'onglet téléchargement, puis
                                    téléchargez et installez sur <br>votre smartphone l'application, d'où vous pourrez
                                    effectuer les transferts.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card-body">
                                <h5 class="card-title">Lien de Téléchargement de l'Application</h5>
                                <img src="\public\assets\sad.png" class="card-img-top"
                                     style="height: 150px;width: 150px;">
                                <p class="card-text">En cliquant sur le lien çi-dessous, vous téléchargerez un fichier
                                    .apk<br>
                                    Vous aurez ensuite à le lancer sur votre smartphone pour que l'application
                                    s'installe.
                                </p>
                                <a href="\public\assets\greencoin.apk" class="btn btn-primary">Télécharger
                                    <b>Greencoin.apk</b></a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="card-body">
                                <h5 class="card-title">Consulter mon solde GreenCoin</h5>
                                <p class="card-text">Vous possédez pour l'instant <span id="coin-amount">X</span> Greencoin(s)</p>

                                <script>
                                    authenticatedFetch("/api/user/read.php")
                                        .then(res => res.json())
                                        .then(json => document.getElementById("coin-amount").innerText = json.information.coins);
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <section>
            <div class="card text-center">
                <div class="card-header">
                    Associations
                </div>
                <br>
                <div class="row" style="padding: 10px;">
                    <?php foreach ($associations as $association) { ?>

                        <div class="col-md-6" style="padding: 10px;">
                            <div>
                                <div class="card h-100">
                                    <img src="/image/association/<?php echo $association["uuid_association"] ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $association["name"]; ?></h5>
                                        <p class="card-text"><?php echo $association["description"]; ?>
                                        <p class="card-text"><small class="text-muted"><a
                                                        href="<?php echo $association["address"]; ?>" class="btn btn-primary"><?php echo $association["name"]; ?></a></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>


                </div>

            </div>
        </section>
        <section>

        </section>
    </main>

<?php include "includes/footer.php"; ?>