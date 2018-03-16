<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$volumes = Volume::findAll();
if(isset($_POST['addprice'])) {
    $prices = new Prices();
    $prices->name = $_POST['name'];
    if(isset($_POST['freedelivery'])) {
        $prices->freedelivery = "TAK";
    }
    $prices->save();

    foreach ($volumes as $volume) {
        $volumesPrices = new VolumesPrices();
        if(isset($_POST['cena' . $volume->volume])) {
            $volumesPrices->volume_id = $volume->id;
            $volumesPrices->prices_id = $prices->id;
            $volumesPrices->price = $_POST['cena' . $volume->volume];
            $volumesPrices->save();
        }
    }

    $session->message("Cennik został dodany pomyślnie");
    header("Location: addprice.php");
}
?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<hr>

<div class="col-lg-4 col-lg-offset-4">
        <p class="bg-success"><?php echo $message; ?></p>
        <form method="post" id="addprice">
            
            <div class="form-group">
                <input type="checkbox" name="freedelivery"> Darmowa dostawa
            </div>

            <div class="form-group">
                <label for="name">Nazwa</label>
                <input class="form-control" type="text" name="name" id="name" maxlength="50" value="">
            </div>
            <?php foreach ($volumes as $volume) : ?>
            <div class="form-group">
                <label for="cena<?php echo $volume->volume; ?>"><?php echo "Kubek " . $volume->volume . " ml";  ?></label>
                <input class="form-control" type="number" step="0.01" name="cena<?php echo $volume->volume; ?>" id="cena<?php echo $volume->volume; ?>" placeholder="Cena" value="">
            </div>
            <?php endforeach; ?>
            <button class="btn btn-sipp pull-right" name="addprice" type="submit">Dodaj Cennik</button>

        </form>
    </div>



<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a').tooltip();
</script >