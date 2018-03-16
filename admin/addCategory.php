<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$categories = Category::findAll();
    if (isset($_POST['addCategory'])) {
        $category = new Category();
        $category->category = $_POST['category'];
        if($category->categoryExists($category->category)) {
            $session->message( "Taka kategoria już istnieje");
        } else {
            $category->save();
            $session->message("Dodano kategorię");
            header("Location: addCategory.php");
        }

    }

?>
<?php require_once 'includes/header_admin.php'; ?>
<?php require_once 'includes/navbar_admin.php'; ?>




<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="categoryForm">
            <h4 id="myModalLabel">
                Dodaj kategorię:
            </h4>

            <!--Wiadomość zwrotna-->
            <p class="bg-success"><?php echo $message; ?></p>
            
            <div class="form-group">
                <label for="name">Nazwa kategorii:</label>
                <input class="form-control" type="text" name="category" id="category" maxlength="50" value="">
            </div>

            <button class="btn btn-sipp pull-right" name="addCategory" type="submit">Dodaj Kategorię</button>

        </form>
    </div>
<div class="container-fluid">

    <table class="table table-bordered table-responsive">

        <thead>
        <tr>
            <th>Id</th>
            <th>Kategoria</th>
            <th>Usuń kategorię</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?php echo $category->id; ?></td>
            <td><?php echo $category->category; ?></td>
            <td>
                <div>
                    <a href="deleteCategory.php?id=<?php echo $category->id; ?>">Usuń</a>
                </div>
            </td>
        </tr>
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
