<?php require_once 'includes/init.php'; ?>
<?php require_once 'includes/header.php'; ?>

    <!--        Navbar dla stron dla niezalogowanych-->
<?php $session->isSignedIn() ? require_once 'includes/navbar_log.php' : require_once 'includes/navbar_nolog.php'; ?>
    </div>
    <div class="container content">
        <h1 class="text-center">Skontaktuj się z nami:</h1>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <span class="glyphicon glyph-big glyphicon-envelope"><span class="text"> kubki@gmail.com</span></span>
            </div>
            <div class="col-lg-6">
                <span class="glyphicon glyph-big glyphicon-earphone"><span class="text"> 524624146</span></span>
            </div>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>