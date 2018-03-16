<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$products = Product::findAll();
if(isset($_POST['delete'])) {
    Product::findById($_POST['id'])->delete();
    $session->message("Pomyslnie usunięto produkt");
    header("Location: products.php");

}
?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>


<!-- wyszukiwanie -->
<hr>

<div class="container-fluid">
    <a href="addProduct.php" class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign"> Dodaj Produkt</span></a>
</div>
<div class="container-fluid">
    <a href="addCategory.php" class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign pull-right">Kategorie</span></a>
</div>
<div class="container-fluid">
    <a href="addVolume.php" class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign pull-right">Pojemności</span></a>
</div>

<hr>

<!-- Tabela z produktami-->


<div class="container-fluid">
    <p class="bg-success"><?php echo $message; ?></p>
    <table class="table table-bordered table-responsive">
        
        <thead>
            <tr>
                <th>Id</th>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Cennik</th>
                <th>Wzór</th>
                <th>Typ</th>
                <th>Data zakończenia</th>
                <th>Pojemność</th>
                <th>Opis</th>
                <th>Status</th>
                <th>Edycja</th>
            </tr>
        </thead>
        
        <tbody>
            

                <?php foreach ($products as $product) : ?>
                <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $product->name; ?></td>
                <td><?php echo Category::findById($product->category_id)->category; ?></td>
                <td><?php echo Prices::findById($product->price_id)->name; ?></td>
                <td><img src="<?php echo $product->picture_path(); ?>" alt="" style="max-height: 100px; max-width: 100px;"> </td>
                <td><?php echo $product->type; ?></td>
                    <td><?php echo $product->end_date; ?></td>
                <td>
                    <?php
                    foreach(VolumesProduct::findByProductId($product->id) as $item) {
                        echo Volume::findById($item->volume_id)->volume . "<br>";
                    }

                    ?>
                </td>
                    <td><?php echo $product->description; ?></td>
                    <td><?php echo $product->status; ?></td>
                    <td>
                        <div class="pull-right"><a href="../admin/editproduct.php?product_id=<?php echo $product->id; ?>" class="btn btn-sipp">Edytuj</a></div>
                    </td>
                    <td>
                        <form method="post">
                            <input hidden="hidden" name="id" value="<?php echo $product->id; ?>">
                        <div class="pull-right"><button type="submit" name="delete" class="btn btn-sipp">Usuń</button></div>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>

            
        </tbody>
    
    </table>

</div>

<!--To coś na dole do nawigacji--> 

<nav aria-label="Page navigation">
    
    <ul class="pagination pull-right">
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
        <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
  </ul>
</nav>



<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a') . tooltip();
</script >