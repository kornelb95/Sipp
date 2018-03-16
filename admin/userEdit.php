<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<div class="container-fluid">

    <div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="loginform">
            <h4 id="myModalLabel">
                Edytuj dane użytkownika:
            </h4>

            <!--Wiadomość zwrotna-->
            <div id="adduserMessage"><?php echo $message ?></div>
            
            <div class="form-group">
                    <label for="login">Login:</label>
                    <input class="form-control" type="text" name="login" id="login" maxlength="50" value="Aktualny login">
            </div>
            
            
            <div class="form-group">
                <label for="password">Email:</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="30" value="Aktualny email">
            </div>
            
            <div class="form-group">
                <label for="password">Zmień hasło:</label>
                <input class="form-control" type="password" name="password" id="password" maxlength="30" value="">
            </div>
            
            <div class="form-group">
                <label for="password">Powtórz hasło:</label>
                <input class="form-control" type="password" name="password-repeat" id="password-repeat" maxlength="30" value="">
            </div>
            
            
            <button class="btn btn-sipp pull-right" name="register" type="submit">Zmień</button>

        </form>
    </div>

    <hr>
    
    <div class="col-lg-4 col-lg-offset-4">
    
        <div class="row">
            <button class="btn btn-sipp">Adres 1</button>   <!--Adresy pobierane z bazy danych-->
            <button class="btn btn-sipp">Adres 2</button>   <!--Po zaznaczeniu adresu, pojawia się formularz edycji adresu-->
        </div>
    
    </div>
    
    <hr>
    
    <!--Formularz edycji adresu-->
    
    <div class="col-lg-4 col-lg-offset-4">
    
        <h3 id="myModalLabel">
                    Dane do wysyłki:
                </h3>

                <div class="form-group">
                    <label for="firstname">Imię:</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" maxlength="50" value="Imię">
                </div>

                <div class="form-group">
                    <label for="lastname">Nazwisko:</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" maxlength="50" value="Nazwisko">
                </div>

                <div class="form-group">
                    <label for="street">Ulica:</label>
                    <input class="form-control" type="text" name="street" id="street" maxlength="50" value="Ulica">
                </div>

                <div class="row">

                    <div class="col-lg-10">

                        <div class="form-group">
                            <label for="housenumber">Numer domu:</label>
                            <input class="form-control" type="number" name="housenumber" id="housenumber" maxlength="50" value="3">
                        </div>

                    </div>


                    <div class="col-lg-2">
                        <label for="login">&nbsp;</label>
                        <div class="form-group">
                            <input class="form-control" type="number" name="username" id="login"maxlength="50" value="15">
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="postcode">Kod pocztowy:</label>
                    <input class="form-control" type="text" name="postcode" id="postcode" maxlength="50" value="Kod pocztowy">
                </div>

                <div class="form-group">
                    <label for="town">Miejscowość:</label>
                    <input class="form-control" type="text" name="town" id="town" maxlength="50" value="Miejscowość">
                </div>

                <div class="form-group">
                    <label for="province">Województwo:</label>
                    <input class="form-control" type="text" name="province" id="province" maxlength="50" value="Województwo">
                </div>
        
                <button class="btn btn-sipp pull-right" name="register" type="submit">Zmień</button>
        
    </div>    
</div>




<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script >
    $('a') . tooltip();
</script >