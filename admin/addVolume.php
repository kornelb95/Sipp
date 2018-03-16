<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$volumes = Volume::findAll();
    if (isset($_POST['addVolume'])) {
        $volume = new Volume();
        $volume->volume = $_POST['volume'];
        if($volume->volumeExists($volume->volume)) {
            $session->message( "Taka pojemność już istnieje");
        } else {
            $volume->save();
            $session->message("Dodano pojemność");
            header("Location: addVolume.php");
        }

    }

?>
<?php require_once 'includes/header_admin.php'; ?>
<?php require_once 'includes/navbar_admin.php'; ?>




<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="volumeForm">
            <h4 id="myModalLabel">
                Dodaj pojemność:
            </h4>

            <!--Wiadomość zwrotna-->
            <p class="bg-success"><?php echo $message; ?></p>
            
            <div class="form-group">
                <label for="name">Pojemność:</label>
                <input class="form-control" type="number" name="volume" id="volume" maxlength="50" value="">
            </div>

            <button class="btn btn-sipp pull-right" name="addVolume" type="submit">Dodaj Pojemność</button>

        </form>
    </div>
<div class="container-fluid">

    <table class="table table-bordered table-responsive">

        <thead>
        <tr>
            <th>Id</th>
            <th>Pojemność</th>
            <th>Usuń pojemność</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($volumes as $volume) : ?>
        <tr>
            <td><?php echo $volume->id; ?></td>
            <td><?php echo $volume->volume; ?></td>
            <td>
                <div>
                    <a href="deleteVolume.php?id=<?php echo $volume->id; ?>">Usuń</a>
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
