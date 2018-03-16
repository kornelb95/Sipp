<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>

<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>


<!--wyszukiwanie -->

<hr>

<div class="container">
    
    <table class="table table=responsive">
        
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th> </th>
            </tr>
        </thead>
        
        <tbody>
            
            <tr>
                <td>Kubek 330ML</td>
                <td><input class="form-control" type="number" name="330" id="330"></td>
                <td><input class="form-control" type="number" name="330" id="330"></td>
                <td><div class="pull-right"><a href="#" class="btn btn-sipp">Zmień</a></div></td><!--uaktualnia ilość-->
            </tr>
            
            <tr>
                <td>Kubek 450ML</td>
                <td><input class="form-control" type="number" name="330" id="330"></td>
                <td><input class="form-control" type="number" name="450" id="450"></td>
                <td><div class="pull-right"><a href="#" class="btn btn-sipp">Zmień</a></div></td><!--uaktualnia ilość-->
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