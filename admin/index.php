<?php require_once '../includes/init.php'; ?>
<?php
if(isset($_POST['logAdmin'])){
    $login = trim($_POST['login']);
    $password = hash('md5',$_POST['password']);

    //Method to check database user
    $adminFound = Admin::verifyAdmin($login, $password);

    if($adminFound){
        $session->loginAdmin($adminFound);
        header('Location:admin.php');
    } else{
        $message = 'Login administratora lub hasło jest niepoprawne';
    }
} else{
    $message = '';
    $login = '';
    $password = '';
}

?>
<?php require_once 'includes/header_admin.php'; ?>

    </div>
    <div class="col-lg-4 col-lg-offset-4">

        <form method="post" id="adminform">
            <h4 id="myModalLabel">
                Logowanie Administrator:
            </h4>

            <!--Wiadomość zwrotna-->
            <div id="loginMessage" class="alert alert-danger"><?php echo $message ?></div>
            <div class="form-group">
                <label for="login">Login administratora</label>
                <input class="form-control" type="text" name="login" id="login" placeholder="Login" maxlength="50" value="">
            </div>
            <div class="form-group">
                <label for="password">Hasło</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Hasło"
                       maxlength="30" value="">
            </div>
            <button class="btn btn-sipp pull-right" name="logAdmin" type="submit">Zaloguj się</button>
        </form>
    </div>
<?php require_once '../includes/footer.php'; ?>