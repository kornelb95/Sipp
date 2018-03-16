<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$product = Product::findById($_GET['product_id']);
$prices = Prices::findAll();
$categories = Category::findAll();
$volumesProducts = VolumesProduct::findByProductId($_GET['product_id']);
$volumes = Volume::findAll();
isset($_POST['changeStatus']) ? $product->status = $_POST['status'] : null;
isset($_POST['changeName']) ? $product->name = $_POST['name'] : null;
isset($_POST['changePrices']) ? $product->price_id = $_POST['prices'] : null;
isset($_POST['changeDate']) ? $product->end_date = $_POST['date'] : null;
isset($_POST['changeCategory']) ? $product->category_id = $_POST['category'] : null;
isset($_POST['changeDescription']) ? $product->description = $_POST['description'] : null;
if(isset($_POST['changePhoto'])) {
    $product->setFile($_FILES['pattern']);
    $product->upload_photo();
}
if(isset($_POST['changeVolume'])){
    foreach ($volumesProducts as $volumesProduct) {
        $volumesProduct->delete();
    }
    if(!empty($_POST['volumes'])) {
        $volumes = $_POST['volumes'];
        foreach ($volumes as $volume) {
            $productVolume = new VolumesProduct();
            $productVolume->product_id = $product->id;
            $productVolume->volume_id = $volume;
            $productVolume->save();
        }
    }
    header("Location: editproduct.php?product_id=" . $_GET['product_id']);
}
$product->save();
?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<hr>

<div class="container">
    
    <h2 class="odstep-gora-1 text-center"><?php echo $product->name; ?></h2>

<!--Menu górne-->


    <a href="#" class="btn btn-lg btn-sipp pull-left" name="produkt" active>Produkt</a>
    <a href="#" class="btn btn-lg btn-sipp pull-left" name="images">Zdjęcia</a>
    
    <span class="odstep-gora-1">&nbsp;</span>
    <span class="odstep-gora-1">&nbsp;</span>
    <hr class="odstep-gora-1">
    <h2>Ustawienia</h2>

    <!--Status (ukryta, dostępna)-->
    

    <hr>
    <form method="post">
    <table class="table table-responsive">

        <tbody>

            <tr>

                <td>Status:</td>
                
                <td>

                    <div class="form-group">
                        <select class="form-control" id="status" name="status">
                            <option value="widoczny" <?php echo ($product->status == "widoczny") ? "selected='selected'" : ''; ?>>widoczny</option>
                            <option value="niewidoczny"<?php echo ($product->status == "niewidoczny") ? "selected='selected'" : ''; ?>>niewidoczny</option>
                        </select>
                    </div>

                </td>
                
                <td><button class="btn btn-sipp" name="changeStatus">Zmień</button></td>

            </tr>

        </tbody>
    
    </table>
    </form>
    <?php if($product->type == 'limitted') : ?>
    <form method="post">
        <table class="table table-responsive">

            <tbody>

            <tr>

                <td>Limitowany:</td>

                <td>

                    <div class="form-group">
                        <label for="date">Poprzednia data zakończenia:</label>  <?php echo $product->end_date; ?>
                        <label for="date">Nowa data zakończenia:</label>
                        <input type="datetime-local" name="date">
                    </div>

                </td>

                <td><button class="btn btn-sipp" name="changeDate">Zmień</button></td>

            </tr>

            </tbody>

        </table>
    </form>
<?php endif; ?>

    
    <h2>Produkt</h2>
    
    <!--Zmiana nazwy-->
    <form method="post">
    <table class="table table-responsive">

        <tbody>
            <tr>
                <td>Nazwa:</td>
                
                <td>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" maxlength="50" value="<?php echo $product->name; ?>">
                    </div>
                </td>
                
                <td><button class="btn btn-sipp" name="changeName">Zmień</button></td>
            </tr>
        </tbody>
    
    </table>
    </form>
    
    
    
<!--    <table class="table table-responsive">-->
<!--        -->
<!--        <tbody>-->
<!--            <tr>-->
<!--                <td>Kod wfirma:</td>-->
<!---->
<!--                <td>-->
<!--                    <div class="form-group">-->
<!--                        <input class="form-control" type="text" name="wfirma" id="wfirma" maxlength="50" value="Poprzednia nazwa wfirma">-->
<!--                    </div>-->
<!--                </td>-->
<!--                -->
<!--                <td><a href="#" class="btn btn-sipp" name="change">Zmień</a></td>                -->
<!--            </tr>-->
<!--        </tbody>-->
<!--    -->
<!--    </table>-->
    
    
    <form method="post" enctype="multipart/form-data">
     <table class="table table-responsive">

        <tbody>
            <tr>
     
                <td>Zdjecie główne:</td>
                
                <td>
                    <img src="<?php echo $product->picture_path(); ?>" width="400px">
                </td>
                
                <td>
                    <div class="form-group">
                        <input class="form-control" type="file" name="pattern" id="pattern">
                    </div>
                </td>
                
                <td>
                    <button class="btn btn-sipp" name="changePhoto">Zmień</button>
                </td>
                
            </tr>
        </tbody>
    
    </table>
    </form>
    
    
    
    
    <hr>
    
    <h2>Cennik</h2>
    <form method="post">
    <table class="table table-responsive">

        <tbody>
            <tr>
       
                <td>
                    <div class="form-group">
                        <select class="form-control" id="prices" name="prices">
                            <?php foreach ($prices as $price) : ?>
                            <option value="<?php echo $price->id; ?>" <?php echo ($price->id == $product->price_id) ? "selected='selected'" : ''; ?>><?php echo $price->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
                
                <td>
                    <button class="btn btn-sipp" name="changePrices">Zmień</button>
                </td>
                
            </tr>
        </tbody>
    
    </table>
    </form>
    
 
    <hr>


    <h2>Kategoria</h2>
    
    
    <form method="post">
    <table class="table table-responsive">

        <tbody>
            <tr>
                
                <td>
                    <div class="form-group">
                        <select class="form-control" id="category" name="category">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $product->category_id) ? "selected='selected'" : ''; ?>><?php echo $category->category; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
                
                <td><button class="btn btn-sipp" name="changeCategory">Zmień</button></td>
            </tr>
        </tbody>
    
    </table>
    </form>

    <hr>

    <h2>Pojemność</h2>


    <form method="post">
    <table class="table table-responsive">

        <tbody>
        <tr>

            <td>
                <div class="form-group">
                    <fieldset>
                        <legend>Wybierz pojemność</legend>
                        <?php foreach ($volumes as $volume) : ?>
                            <div>
                                <input type="checkbox" id="volume" name="volumes[]" value="<?php echo $volume->id;  ?>" <?php foreach ($volumesProducts as $volumesProduct){echo ($volume->id == $volumesProduct->volume_id) ? "checked='checked'" : '';} ?>>
                                <label for="volume"><?php echo $volume->volume;  ?></label>
                            </div>
                        <?php endforeach; ?>

                    </fieldset>
                </div>
            </td>

            <td><button class="btn btn-sipp" name="changeVolume">Zmień</button></td>
        </tr>
        </tbody>

    </table>
    </form>

    <hr>

    <h2>Opis</h2>
    <form method="post">
    <table class="table table-responsive">

        <tbody>
            <tr>
                
                <td>
                    <textarea rows="10" cols="70" name="description">
                        <?php echo $product->description; ?>
                    </textarea>
                </td>
                
                <td><button class="btn btn-sipp" name="changeDescription">Zmień</button></td>
            </tr>
        </tbody>
    
    </table>
    </form>
    
    <table class="table table-responsive">

        <tbody>
            <tr>
                <td>Tagi:</td>
                
                <td>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" maxlength="50" value="Poprzednie tagi">
                    </div>
                </td>
                
                <td><a href="#" class="btn btn-sipp" name="change">Zmień</a></td>
            </tr>
        </tbody>
    
    </table>
    
    
    

</div>
   




<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a') . tooltip();
</script >