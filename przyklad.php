<?php require_once 'includes/init.php'; ?>
<?php
if(isset($_GET['product_id'])) {
    $product = Product::findById($_GET['product_id']);
    $volumes = VolumesProduct::findByProductId($_GET['product_id']);
}
if(isset($_POST['addtocart'])) {
    if (!isset($_POST['volumes'])) {
        $session->errorMessage("Proszę wybrać pojemność");
        header("Location: przyklad.php?product_id=" . $product->id);
        die;
    }


    $volume_id = $_POST['volumes'];
    $volume = Volume::findById($volume_id)->volume;
    $productsArray['id'] = $product->id;
    $productsArray['photo'] = $product->picture_path();
    $productsArray['name'] = $product->name;
    $productsArray['price'] = VolumesPrices::findByVolumeAndPrices($volume_id, $product->price_id)->price;
    $productsArray['volume'] = $volume;
    $productsArray['amount'] = 1;
    if(!isset($_SESSION['cartProducts'][$product->name . $volume])){
        $_SESSION['cartProducts'][$product->name . $volume] = $productsArray;
    } else {
        $_SESSION['cartProducts'][$product->name . $volume]['amount']++;
    }

    $session->message("Dodano " . $product->name . " do koszyka");
    header("Location: przyklad.php?product_id=" . $product->id);
}
?>
<?php require_once 'includes/header.php';?>
<!--        Navbar dla stron dla niezalogowanych-->
<?php $session->isSignedIn() ? require_once 'includes/navbar_log.php' : require_once 'includes/navbar_nolog.php'; ?>
</div>
    <div class="container">
        <div class="row">
            <h1 class="text-center"><?php echo $product->name; ?></h1>
            <p class="bg-danger"><?php echo $errorMessage; ?></p>
            <p class="bg-success"><?php echo $message; ?></p>
            <hr>
            <div class="col-lg-6">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0"></li>
                        <li data-target="#carousel" data-slide-to="1"></li>
                        <li data-target="#carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 1">
                        </div>
                        <div class="item">
                            <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 2">
                        </div>
                        <div class="item">
                            <img src="admin/<?php echo $product->picture_path(); ?>" alt="Slide 3">
                        </div>
                    </div>
                    <a href="#carousel" class="left carousel-control" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a href="#carousel" class="right carousel-control" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <h2><?php echo $product->name; ?></h2>
                <hr>
                <p>
                <?php echo $product->description; ?>
                </p>
                <hr>
                <form method="post">
                <div class="row">
                    <p>Wybierz pojemnosć:</p>
                    <div id="radioGroup" class="btn-group buttons-size" data-toggle="buttons">
                        <!--<button type="button" class="btn btn-secondary">330 ml</button>
                        <button type="button" class="btn btn-secondary">450 ml</button>-->
                        <?php foreach ($volumes as $volume) : ?>
                        <label class="priceRadio btn btn-sipp">
                            <input class="priceOption" type="radio" name="volumes" value="<?php echo $volume->volume_id; ?>" id="<?php echo VolumesPrices::findByVolumeAndPrices($volume->volume_id, $product->price_id)->price; ?>" autocomplete="off">
                            <?php echo Volume::findById($volume->volume_id)->volume; ?> ml
                        </label>
<!--                        -->
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" name="addtocart" class="btn btn-sipp-inverse pull-right">Dodaj do koszyka</button>
                </div>
                </form>
               <div class="row">
                   <h1 id="cenapojemnosc"></h1>
               </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <h3 class="text-center">Sprawdź jeszcze:</h3>
        <hr>
    </div>


<?php require_once 'includes/footer.php'; ?>
