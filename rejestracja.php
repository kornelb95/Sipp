<?php require_once 'includes/init.php'; ?>
<?php if($session->isSignedIn()) {header("Location: logowanie.php");} ?>
<?php require_once 'includes/header.php'; ?>
<?php
if(isset($_POST['register'])) {
    $user = new User();
    $user->username = $_SESSION['memname'] = isset($_POST['username']) ? filter_input(INPUT_POST, 'username') : '';
    $user->email = $_SESSION['mememail'] = isset($_POST['email']) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : '';
    $user->password = isset($_POST['password']) ? filter_input(INPUT_POST, 'password') : '';
    $user->password2 = isset($_POST['password2']) ? filter_var($_POST["password2"], FILTER_SANITIZE_STRING) : '';
    if($user->register()) {
        unset($_SESSION['memname']);
        unset($_SESSION['mememail']);
    } else {
        header("Location: rejestracja.php");
    }

}
?>
<!--        Navbar dla stron dla niezalogowanych-->
<?php require_once 'includes/navbar_nolog.php'; ?>
</div>

<!--<div class="container-fluid">
    <div class="row col-md-4 col-md-offset-3">

        <form action="rejestracja.php" method="post" role="form">

            <div class="form-group">
                <label class="control-label">Nazwa użytkownika:<span>*</span></label>
                <div>
                    <input name="username" value="" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">Adres E-mail:<span>*</span></label>
                <div>
                    <div class="input-group">
                        <input type="email" name="email" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Hasło:<span>*</span></label>
                <div>
                    <div class="input-group">
                        <input type="password" name="password1" id="password1" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Powtórz hasło:<span>*</span></label>
                <div>
                    <div class="input-group">
                        <input type="password" name="password2" id="password2" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="submit" title="Rejestracja" class="btn-sipp">Rejestracja</button>
                </div>
            </div>
        </form>
    </div>
</div>-->

<div class="col-lg-4 col-lg-offset-4">
    <p class="bg-danger"><?php echo $message; ?></p>
        <form method="post" id="registerform">
            <h4 id="myModalLabel">
                Rejestracja:
            </h4>

            <!--Wiadomość zwrotna-->
            <div id="registerMessage">

            </div>
            
            <div class="form-group">
                <label for="login">Nazwa użytkownika:</label>
                <input class="form-control" type="text" name="username" id="login" placeholder="Login" maxlength="50" value="<?php echo $_SESSION['memname']; ?>">
            </div>
            
            <div class="form-group">
                <label for="login">Email:</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email" maxlength="50" value="<?php echo $_SESSION['mememail']; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Hasło"
                       maxlength="30">
            </div>
            
            <div class="form-group">
                <label for="password-reteat">Powtórz hasło:</label>
                <input class="form-control" type="password" name="password2" id="password-repeat" placeholder="Hasło"
                       maxlength="30">
            </div>
            
            <button class="btn btn-sipp pull-right" name="register" id="register" type="submit">Zarejestuj się</button>

        </form>
    </div>

<div class="container-fluid odstep-gora-1">
    <footer class="footer">
        <p> Copyright 2018 &copy; Sipp </p>
    </footer>
</div>


<!--javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="javascript">
    $('a').tooltip();
</script>
</body>
</html>