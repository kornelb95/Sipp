<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$categories = Category::findAll();
$volumes = Volume::findAll();
$prices = Prices::findAll();
$limitted = Product::HowManyLimitted();
if(isset($_POST['addProduct'])) {
    $product = new Product();
    $product->name = $_POST['name'];
    $product->category_id = $_POST['category'];
    $product->type = $_POST['type'];
    if($product->type == 'limitted' && $limitted == 3) {
        $session->errorMessage("W bazie są już trzy produkty limitowane");
        header("Location: addProduct.php");
        die;
    }
    $product->status = $_POST['status'];

    $product->end_date = $product->type == "limitted" ? $_POST['date'] : null;
    $product->description = $_POST['description'];
    $product->price_id = $_POST['price'];
    $product->setFile($_FILES['pattern']);
    $product->upload_photo();
    $product->save();
    
    $volumes = [];
    if(!empty($_POST['volumes'])) {
        $volumes = $_POST['volumes'];
        foreach ($volumes as $volume) {
            $productVolume = new VolumesProduct();
            $productVolume->product_id = $product->id;
            $productVolume->volume_id = $volume;
            $productVolume->save();
        }
    }
    $session->message("Produkt został dodany pomyslnie");
    header("Location: addProduct.php");
}

?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>




<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="productForm" enctype="multipart/form-data">
            <h4 id="myModalLabel">
                Dodaj produkt:
            </h4>

            <!--Wiadomość zwrotna-->
            <p class="bg-success"><?php echo $message; ?></p>
            <p class="bg-danger"><?php echo $errorMessage; ?></p>
            <div class="form-group">
                <label for="name">Nazwa:</label>
                <input class="form-control" type="text" name="name" id="name" maxlength="50" value="">
            </div>


            <div class="form-group">
                <label for="category">Kategoria:</label>
                <select class="form-control" id="category" name="category">
                    <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category->id; ?>"><?php echo $category->category;  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price">Cennik:</label>
                <select name="price">
                    <?php foreach ($prices as $price) : ?>
                        <option value="<?php echo $price->id; ?>"><?php echo $price->name;  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="type">Typ:</label>
                <select name="type" id="type">
                    <option selected="selected"></option>
                    <option value="shop">Sklep</option>
                    <option value="limitted">Limitowany</option>
                </select>
            </div>
            <div class="form-group" id="date" hidden="hidden">
                <label for="date">Data zakończenia:</label>
                <input type="datetime-local" name="date">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status">
                    <option value="widoczny">widoczny</option>
                    <option value="niewidoczny">niewidoczny</option>
                </select>
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>Wybierz pojemność</legend>
                    <?php foreach ($volumes as $volume) : ?>
                    <div>
                        <input type="checkbox" id="volume" name="volumes[]" value="<?php echo $volume->id;  ?>">
                        <label for="volume"><?php echo $volume->volume;  ?></label>
                    </div>
                    <?php endforeach; ?>

                </fieldset>
            </div>
            
            <div class="form-group">
                <label for="pattern">Wzór:</label>
                <input class="form-control" type="file" name="pattern" id="pattern">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control"
                          name="description"></textarea>

            </div>
            
            <button class="btn btn-sipp pull-right" name="addProduct" type="submit">Dodaj produkt</button>

        </form>
    </div>



<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script src = "script.js" ></script >
<script >
    $('a').tooltip();
</script >
