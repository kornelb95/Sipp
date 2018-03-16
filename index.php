<?php require_once 'includes/init.php'; ?>
<?php if($session->isSignedIn()) {header("Location: main.php");} ?>
<?php

$categories = Category::findAll();
$products = Product::findAll();
$volumes = Volume::findAll();
if(isset($_POST['addtocart'])) {
    if ($_POST['price'] == 'nooption' ) {
        $session->errorMessage("Proszę wybrać pojemność");
        header("Location: index.php");
        die;
    }

    $product = Product::findById($_POST['cartproduct']);
    $volume = Volume::findById(VolumesPrices::findVolumeIdByPriceAndPriceId($product->price_id, $_POST['price'])->volume_id)->volume;
    $productsArray['id'] = $product->id;
    $productsArray['photo'] = $product->picture_path();
    $productsArray['name'] = $product->name;
    $productsArray['price'] = $_POST['price'];
    $productsArray['volume'] = $volume;
    $productsArray['amount'] = 1;
    $_SESSION['cartProducts'][$product->name . $volume] = $productsArray;
    $session->message("Dodano " . $product->name . " do koszyka");
    header("Location: index.php");
}
?>
<?php require_once 'includes/header.php'; ?>

    <!--        Navbar dla stron dla niezalogowanych-->
<?php require_once __DIR__ . '/includes/navbar_nolog.php'; ?>

    </div>

    <h2 class="text-center">Oferta limitowana:</h2>
    <hr>

    <div class="container-fluid">
        <div class="row">
            <p class="bg-danger text-center"><?php echo $errorMessage; ?></p>
            <p class="bg-success text-center"><?php echo $message; ?></p>
            <?php $count = 0; ?>
            <?php foreach ($products as $product) : ?>

                <?php if(($product->type == 'limitted') && $product->status == 'widoczny') : ?>
                    <?php $count++ ?>
                    <?php if($count ==4 ) {break;} ?>
                    <div class="col-lg-4" id="carouselLimittedContainer">
                        <div id="carousel<?php echo $count; ?>" class="carousel slide carousel-margin" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel<?php echo $count; ?>" data-slide-to="0"></li>
                                <li data-target="#carousel<?php echo $count; ?>" data-slide-to="1"></li>
                                <li data-target="#carousel<?php echo $count; ?>" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">

                                <div class="item active">
                                    <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 1" style="width:400px; height: 400px;">
                                </div>
                                <div class="item">
                                    <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 2" style="width:400px; height: 400px;">
                                </div>
                                <div class="item">
                                    <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 3" style="width:400px; height: 400px;">
                                </div>
                            </div>
                            <a href="#carousel<?php echo $count; ?>" class="left carousel-control" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a href="#carousel<?php echo $count; ?>" class="right carousel-control" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                            <div hidden="hidden" id="carouselCounter"><?php echo Product::HowManyLimitted();  ?></div>
                        </div>

                        <div class="opis-limit">
                            <div class="row odstep-dol-1">
                                <div class="col-md-8">
                                    <h1><?php echo $product->name; ?></h1>
                                </div>

                                <!--                    <div class="col-md-4 cena">-->
                                <!--                        --><?php //foreach (VolumesProduct::findByProductId($product->id) as $volumesProduct) : ?>
                                <!--                            <h1 hidden="hidden" id="--><?php //echo $volumesProduct->volume_id; ?><!--">--><?php //echo VolumesPrices::findByVolumeAndPrices($volumesProduct->volume_id, $product->price_id)->price; ?><!--</h1>-->
                                <!--                        --><?php //endforeach; ?>
                                <!---->
                                <!--                    </div>-->
                                <div class="col-md-4 cena">

                                    <h1 id="cenapojemnosc<?php echo $count; ?>"></h1>


                                </div>

                            </div>
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
<!--                                            <label for="pojemnosc--><?php //echo $count; ?><!--">Wybierz pojemność aby sprawdzić cenę</label>-->
                                            <select class="form-control" name="price" id="pojemnosc<?php echo $count; ?>">
<!--                                                <option value="nooption"></option>-->
                                                <?php foreach (VolumesProduct::findByProductId($product->id) as $volumesProduct) : ?>
                                                    <option id="<?php echo $count; ?>" value="<?php echo VolumesPrices::findByVolumeAndPrices($volumesProduct->volume_id, $product->price_id)->price; ?>"><?php echo Volume::findById($volumesProduct->volume_id)->volume . " ml"; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4 pull-right btn-order">

                                        <input hidden="hidden" name="cartproduct" value="<?php echo $product->id; ?>">
                                        <button id="#" type="submit" name="addtocart" class="btn btn-sipp-inverse btn-block" onclick="#">Dodaj do
                                            koszyka
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>



        </div>
        <h2 class="text-center odstep-gora-1">Kategorie:</h2>
        <hr>
        <div class="container">
            <div class="row">
                <?php foreach ($categories as $category) : ?>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="project">
                            <div class="project-img">
                                <a href="kubki.php?category_id=<?php echo $category->id; ?>" class="btn-ghost btn-hover">Wejdź</a>
                                <p><img src="images/kubek.jpg" alt="kubek" class="img-responsive"></p>
                            </div>
                            <p class="text-center">Kubki <?php echo $category->category; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <hr>
<?php require_once 'includes/footer.php'; ?>