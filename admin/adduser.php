<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>




<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="loginform">
            <h4 id="myModalLabel">
                Rejestracja użytkownika:
            </h4>

            <!--Wiadomość zwrotna-->
            <div id="adduserMessage"><?php echo $message ?></div>
            
            <div class="form-group">
                <label for="login">Login:</label>
                <input class="form-control" type="text" name="login" id="login" maxlength="50" value="">
            </div>
            
            
            <div class="form-group">
                <label for="password">Email:</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="30" value="">
            </div>
            
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input class="form-control" type="password" name="password" id="password" maxlength="30" value="">
            </div>
            
            <div class="form-group">
                <label for="password">Powtórz hasło:</label>
                <input class="form-control" type="password" name="password-repeat" id="password-repeat" maxlength="30" value="">
            </div>
            
            
            <button class="btn btn-sipp pull-right" name="register" type="submit">Zarejestruj użytkownika</button>

        </form>
    </div>



<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a') . tooltip();
</script >
