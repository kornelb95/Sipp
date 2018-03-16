<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$products = Product::findAll();

?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<hr>

<div class="container">

    <!--dodawanie zdjęć-->
    
    <h2>Dodawanie zdjęć:</h2>
    
    <table class="table table-responsive">
                
        <tbody>
            <tr>  
                
                <td>
                    <div class="form-group">
                        <input class="form-control" type="file" name="pattern" id="pattern">
                    </div>
                </td>
                
                <td>
                    <a href="#" class="btn btn-sipp" name="change">Dodaj</a>
                </td>
                
            </tr>
        </tbody>
    
    </table>

    <hr>
    
    <h2>Podgląd i edycja:</h2>
    
    <table class="table table-responsive table-bordered">
        
        <thead>
            <tr>
                <th>#</th>
                <th>Zdjęcie</th>
                <th>Zmień</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                
                <td>1</td>
                
                <td>
                    <img src="../images/i-sagaform-kubek-jamaica-duzy-czarny-5016154.jpg" width="1000px">
                </td>
                
                <td>
                    <div class="form-group">
                        <input class="form-control" type="file" name="pattern" id="pattern">
                    </div>
                </td>
                
                <td>
                    <a href="#" class="btn btn-sipp" name="change">Zmień</a>
                    <a href="#" class="btn btn-sipp" name="remove">Usuń</a>
                </td>
                
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