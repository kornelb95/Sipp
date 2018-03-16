<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
if(isset($_GET['prices_id'])) {
    $volumesPrices = VolumesPrices::findByPricesId($_GET['prices_id']);

        foreach ($volumesPrices as $volumesPrice) {
            if(isset($_POST['change' . $volumesPrice->id])) {
                if($volumesPrice->id == $_POST['id']) {
                    $volumesPrice->price = $_POST[Volume::findById($volumesPrice->volume_id)->volume];
                    $volumesPrice->save() ? $session->message("Pomyslnie zmieniono cenę") : $session->message("Błąd");
                    header("Location: priceedit.php?prices_id=" . $_GET['prices_id']);
                }
            }

        }
}
if(isset($_POST['changeName'])){
    $price = Prices::findById($_GET['prices_id']);
    $price->name = $_POST['name'];
    $price->save();
    header("Location: priceedit.php?prices_id=" . $_GET['prices_id']);
}

?>
<?php require_once 'includes/header_admin.php'; ?>
<?php require_once 'includes/navbar_admin.php'; ?>

<hr>

<div class="container">
    
    <table class="table table=responsive">
        <p class="bg-success"><?php echo $message; ?></p>

        
        <form method="post">
            <label for="name">Nazwa cennika:</label>
            <input type="text" value="<?php echo Prices::findById($_GET['prices_id'])->name; ?>" name="name">
            <button type="submit" name="changeName">Zmień nazwę</button>
        </form>
        
        <br>


        
        <thead>
            <tr>
                <th>Pojemność</th>
                <th>Cena obecna</th>
                <th>Zmień na</th>
                <th> </th>
            </tr>
        </thead>
        
        <tbody>
        <?php foreach ($volumesPrices as $volumesPrice) : ?>
            <form method="post">
            <tr>
                <td><?php echo "Kubek " . Volume::findById($volumesPrice->volume_id)->volume . " ML"; ?></td>
                <td><?php echo $volumesPrice->price; ?></td>

                <td>

                        <input type="hidden" name="id" value="<?php echo $volumesPrice->id; ?>">
                    <input class="form-control" type="number" step="0.01" name="<?php echo Volume::findById($volumesPrice->volume_id)->volume; ?>" id="<?php echo Volume::findById($volumesPrice->volume_id)->volume; ?>"></td>
                <td>
                    <div class="pull-right">
                        <button type="submit" name="change<?php echo $volumesPrice->id; ?>" class="btn btn-sipp">Zmień</button>
                    </div>

                </td><!--uaktualnia cenę obecną-->


            </tr>
            </form>
        <?php endforeach; ?>
            
        
        </tbody>
    </table>
    
</div>


<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a').tooltip();
</script >