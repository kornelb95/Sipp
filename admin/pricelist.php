<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$prices = Prices::findAll();

if (isset($_GET['id'])) {
    $price = Prices::findById($_GET['id']);
    $price->delete() ? $session->message("Usunięto Cennik") : $session->message("Nie udało się usunąć cennika");
    header("Location: pricelist.php");

}

?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<hr>

<div class="container-fluid">
    <a href="addprice.php" class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign"> Dodaj cennik</span></a>
</div>

<hr>
<form method="post">
<div class="container">
    
    <table class="table table-bordered table-responsive">
        
        <thead>
            <tr>
                <th>Nazwa cennika</th>
                <th>Edycja</th>
            </tr>
        </thead>
        
        <tbody>
        <?php foreach ($prices as $price) : ?>
            <tr>
                <td><?php echo $price->name; ?></td>
                <td><div class="pull-right"><a href="../admin/priceedit.php?prices_id=<?php echo $price->id; ?>" class="btn btn-sipp">Edytuj</a>
                        <a href="pricelist.php?id=<?php echo $price->id; ?>" class="btn btn-sipp">Usuń</a></div></td>
            </tr>
            <?php endforeach; ?>
            
        </tbody>
    
    </table>
</div>
</form>
<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a') . tooltip();
</script >