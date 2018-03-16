<?php require_once 'includes/init.php'; ?>
<?php require_once 'includes/header.php'; ?>

<!--        Navbar dla stron dla niezalogowanych-->
<?php require_once 'includes/navbar_nolog.php'; ?>
</div>
<div class="container content">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            <h1>Aktywowanie konta</h1>
            <?php
            //zmienne zawierające email i klucz aktywacji
            $user = new User();
            $email = $_GET['email'];
            $key = $_GET['key'];
            print_r($user->activate($email, $key));
            ?>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>