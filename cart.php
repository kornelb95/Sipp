<?php require_once 'includes/init.php'; ?>
<?php
$cartProducts = $_SESSION['cartProducts'];
if(isset($_GET['name'])) {
    unset($_SESSION['cartProducts'][$_GET['name'] . $_GET['volume']]);
    header("Location: cart.php");
}
if(isset($_POST['finalize'])) {
    $order = new Orders();
    $order->user_id = $session->isSignedIn() ? $session->user_id : null;
    $order->email = $_POST['email'];
    $order->totalcost = $_SESSION['total'];
    $order->first_name = $_POST['firstname'];
    $order->last_name = $_POST['lastname'];
    $order->street = $_POST['street'];
    $order->house_number = $_POST['housenumber'];
    $order->post_code = $_POST['postcode'];
    $order->town = $_POST['town'];
    $order->status = "Oczekiwanie na płatność";
    $order->province = $_POST['province'];
    $order->send_method = $_POST['sendmethod'];
    $order->pay_method = $_POST['paymethod'];
    if($order->save()) {
        foreach ($cartProducts as $cartProduct) {
            $productsOrder = new ProductsOrder();
            $productsOrder->order_id = $order->id;
            $productsOrder->product_id = $cartProduct['id'];
            $productsOrder->volume_id = Volume::findIdByVolume($cartProduct['volume'])->id;
            $productsOrder->amount = $cartProduct['amount'];
            $productsOrder->save();
        }
        unset($_SESSION['cartProducts']);
        $session->message("Pomyślnie złożono zamówienie");
        header("Location: cart.php");
    } else {
        $session->errorMessage("Nie udało sie złożyć zamówienia");
    }



}
if(isset($_GET['up'])) {
   echo $_SESSION['cartProducts'][$_GET['namevolume']]['amount']++;
    header("Location: cart.php");
}
if(isset($_GET['down']) && $_GET['down'] == 'yes') {
    echo $_SESSION['cartProducts'][$_GET['namevolume']]['amount']--;
    if($_SESSION['cartProducts'][$_GET['namevolume']]['amount'] == 0) {
        $_SESSION['cartProducts'][$_GET['namevolume']]['amount'] = 1;
    }
    header("Location: cart.php");
}
?>
<?php require_once 'includes/header.php'; ?>
<?php require_once($session->isSignedIn() ? 'includes/navbar_log.php' : 'includes/navbar_nolog.php'); ?>

<!--        Navbar dla stron dla niezalogowanych-->


<h1 class="text-center">Twój koszyk:</h1>
<p class="bg-danger"><?php echo $errorMessage; ?></p>
<p class="bg-success"><?php echo $message; ?></p>
<table class="table table-striped">
     
    <thead>
        <tr><td width="5%"></td>
            <td width="15%" class="align-left"></td>
            <td width="40%"></td>
            <td width="14%">Produkt</td>
            <td width="14%">Ilość</td>
            <td width="12%">Cena</td>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
        <?php foreach ($cartProducts as $cartProduct) : ?>

        <tr>
             <td class="remove-item"><a href="cart.php?name=<?php echo $cartProduct['name'] . "&volume=" . $cartProduct['volume']; ?>" target="_self" title="Usuń produkt z koszyka"><span class="glyphicon glyphicon-remove"></span></a></td>
             <td><img src="admin/<?php echo $cartProduct['photo']; ?>" width="90" style="background-color:#a6cae8"></td>
             <td class="align-left"><?php echo $cartProduct['name']; ?></td>
             <td><strong>Kubek</strong><br><em><?php echo $cartProduct['volume'] . "ml"; ?></em></td>
             <td> &nbsp;&nbsp;<a href="cart.php?namevolume=<?php echo $cartProduct['name'].$cartProduct['volume'];?>&up=yes" title="Zwiększ ilość">+</a>&nbsp;&nbsp;<?php echo $cartProduct['amount']; ?>&nbsp;
                 &nbsp;&nbsp;<a href="cart.php?namevolume=<?php echo $cartProduct['name'].$cartProduct['volume'];?>&down=yes" title="Zmniejsz ilość">-</a>
             </td>
             <td><?php echo $totalprice =  $cartProduct['price'] * $cartProduct['amount']; ?>zł</td>
            <?php $total += $totalprice; ?>
        </tr> 
        <?php endforeach; ?>
        

        <tr> 
            <td colspan="3"></td>
            <td>Łącznie:</td>
            <td><?php echo $_SESSION['total'] = $total . " zł"; ?></td>
        </tr>
      
     </tbody>
</table>
<a href="#" class="btn btn-big btn-sipp-inverse pull-right">Kontynuuj</a>


<form method="post">
<div class="col-lg-8 col-lg-offset-2 odstep-gora-1"> <!--Wyświetla się po kliknięciu kontynuuj-->


            <h3 id="myModalLabel">
                Dane do wysyłki:
            </h3>

            <div class="form-group">
                <label for="firstname">Imię:</label>
                <input class="form-control" type="text" name="firstname" id="firstname" maxlength="50" value="">
            </div>
            
            <div class="form-group">
                <label for="lastname">Nazwisko:</label>
                <input class="form-control" type="text" name="lastname" id="lastname" maxlength="50" value="">
            </div>
            
            <div class="form-group">
                <label for="street">Ulica:</label>
                <input class="form-control" type="text" name="street" id="street" maxlength="50" value="">
            </div>
            
            <div class="row">
                
                <div class="col-lg-10">

                    <div class="form-group">
                        <label for="housenumber">Numer domu:</label>
                        <input class="form-control" type="number" name="housenumber" id="housenumber" maxlength="50" value="">
                    </div>

                </div>
                
                <div class="col-lg-2">
                    <label for="login">&nbsp;</label>
                    <div class="form-group">
                        <input class="form-control" type="number" name="username" id="login"maxlength="50" value="">
                    </div>

                </div>
            
            </div>
            
            <div class="form-group">
                <label for="postcode">Kod pocztowy:</label>
                <input class="form-control" type="text" name="postcode" id="postcode" maxlength="50" value="">
            </div>
            
            <div class="form-group">
                <label for="town">Miejscowość:</label>
                <input class="form-control" type="text" name="town" id="town" maxlength="50" value="">
            </div>
            
            <div class="form-group">
                <label for="province">Województwo:</label>
                <input class="form-control" type="text" name="province" id="province" maxlength="50" value="">
            </div>
            
          

    
    <a href="#" class="btn btn-big btn-sipp-inverse pull-right">Zatwierdź dane</a>    
</div>

<div class="col-lg-8 col-lg-offset-2 odstep-gora-1"> <!--Wyświetla się po kliknięciu Zatwierdź dane-->
    <h3>Metoda wysyłki:</h3>
    

        <table class="table table-bordered table-responsive">
            <tbody>
                <tr>
                    <td align="left">
                        <div id="payment1" class="checkbox">
                            <table class="table table-inner borderless">
                                <tbody>
                                    <tr>
                                        <td valign="middle" width="6%" class="table-radio"><input type="radio" name="sendmethod" value="poczta" data-commission="0" onchange="recalculateDiscount()"></td>
                                        <td width="28%"><img src="" alt="logo" title="logo"></td>
                                        <td width="52%">
                                        <div><strong>Poczta</strong><br>Wygodna i bezpieczna<br>
                                            (brak dodatkowych oplat)</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn btn-big btn-sipp-inverse pull-right">Kontynuuj</a>
</div>


<div class="col-lg-8 col-lg-offset-2 odstep-gora-1"> <!--Wyświetla się po kliknięciu Kontynuuj-->
    <h3>Metoda płatności:</h3>
    

        <table class="table table-bordered table-responsive">
            <tbody>
                <tr>
                    <td align="left">
                        <div id="payment1" class="checkbox">
                            <table class="table table-inner borderless">
                                <tbody>
                                    <tr>
                                        <td valign="middle" width="6%" class="table-radio"><input type="radio" name="paymethod" value="ecard" data-commission="0" onchange="recalculateDiscount()"></td>
                                        <td width="28%"><img src="" alt="logo" title="logo"></td>
                                        <td width="52%">
                                        <div><strong>eCard</strong><br>Wygodna i bezpieczna płatność przy użyciu karty lub e-przelewu<br>
                                            (brak dodatkowych oplat)</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn btn-big btn-sipp-inverse pull-right">Kontynuuj</a>
</div>
                               
<div class="col-lg-8 col-lg-offset-2 odstep-gora-1"> <!--Wyświetla się po kliknięciu Kontynuuj-->
    
    <div class="form-group">
        <label for="login">Podaj email:</label>
        <input class="form-control" type="email" name="email" id="email" maxlength="50" value="">
    </div>
    
    <button type="submit" name="finalize" class="btn btn-big btn-sipp-inverse pull-right">Sfinalizuj transakcję</button>
</div>
</form>
    
    
    
    
<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "js/bootstrap.min.js" ></script >
<script >
    $('a').tooltip();
</script >