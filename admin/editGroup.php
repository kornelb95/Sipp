<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>


<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">
    
    <div class="form-group"> <!-- wybór grupy-->
        <label for="groupname">Grupa:</label>
        <select class="form-control" id="groupname" name="groupname">
            <option>Kody do cybermychy</option>
            <option>Kody w współpracy z Grupą Linoskoczkową</option>
        </select>
    </div>

    <div class="form-group odstep-gora-1">
        <label for="name">Nazwa:</label>
        <input class="form-control" type="text" name="name" id="name" value="">
    </div>
    <button class="btn btn-sipp">Usuń grupę</button>
    <button class="btn btn-sipp-inverse pull-right">Zmień</button>
    
    
</div>




<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script src = "script.js" ></script >
<script >
    $('a').tooltip();
</script >
