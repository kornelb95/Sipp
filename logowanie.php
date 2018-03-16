<?php require_once 'includes/init.php'; ?>
<?php if($session->isSignedIn()) {header("Location: main.php");} ?>
<?php
if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = hash('sha256',$_POST['password']);


    //Method to check database user
    $userFound = User::verifyUser($username, $password);

    if($userFound){
        $session->login($userFound);
        header('Location:main.php');
    } else{
        $session->message( 'Nazwa użytkownika lub hasło jest niepoprawne');
        header("Location: logowanie.php");
    }
} else{
    $username = '';
    $password = '';
}

?>
<?php require_once 'includes/header.php'; ?>


    <!--        Navbar dla stron dla niezalogowanych-->
<?php require_once 'includes/navbar_nolog.php'; ?>
</div>
    <div class="col-lg-4 col-lg-offset-4">

        <form method="post" id="loginform">
            <h4 id="myModalLabel">
                Logowanie:
            </h4>

            <!--Wiadomość zwrotna-->
            <p class="bg-danger"><?php echo $message; ?></p>

            <div class="form-group">
                <label for="login">Nazwa użytkownika</label>
                <input class="form-control" type="text" name="username" id="login" placeholder="Login" maxlength="50" value="">
            </div>
            <div class="form-group">
                <label for="password">Hasło</label><span class="pull-right"><a href="#">Zapomniałeś hasła?</a></span>
                <input class="form-control" type="password" name="password" id="password" placeholder="Hasło"
                       maxlength="30" value="">
            </div>
            <button class="btn btn-sipp pull-right" name="login" type="submit">Zaloguj się</button>

            <a href="rejestracja.php" class="btn btn-sipp-inverse pull-left">Załóż konto</a>
        </form>
    </div>
<?php require_once 'includes/footer.php'; ?>