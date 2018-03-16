<?php require_once '../includes/init.php'; ?>
<?php

$order = isset($_GET['order_id']) ? Orders::findById($_GET['order_id']) : null;
if(isset($_POST['editAmount'])) {
    $productOrder = ProductsOrder::findById($_POST['id']);
    $lastAmount = $productOrder->amount;
    $productPrice = VolumesPrices::findByVolumeAndPrices($productOrder->volume_id, Product::findById($productOrder->product_id)->price_id)->price;
    $productOrder->amount = $_POST['amount'];
    $order->totalcost -= ($productPrice*$lastAmount);
    $order->totalcost += $productOrder->amount * $productPrice;
    $order->save();
    $productOrder->save() ? $session->message("Ilość została zmieniona") : null;
    header("Location: editorder.php?order_id=".$_GET['order_id']);
}
if(isset($_POST['changeOrder'])) {
    $order->email = $_POST['email'];
    $order->first_name = $_POST['firstname'];
    $order->last_name = $_POST['lastname'];
    $order->street = $_POST['street'];
    $order->house_number = $_POST['housenumber'];
    $order->post_code = $_POST['post_code'];
    $order->town = $_POST['town'];
    $order->save() ? $session->message("Dane zamówienia zostały zmienione") : null;
    header("Location: editorder.php?order_id=".$_GET['order_id']);
}
?>
<?php if (!$session->isSignedInAdmin()) {
    header("Location: index.php");
} ?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>

<div class="container-fluid">



        <h3><?php echo "<br><br><br>"; ?>

            Edytuj zamówienie
            użytkownika <?php echo is_null(User::findById($order->user_id)) ? "niezarejestrowany" : User::findById($order->user_id)->username; ?>
            <?php echo "<br>"; ?>Id zamówienia: <?php echo $order->id; ?>
        </h3>
        <hr>
    <p class="bg-success"><?php echo $message; ?></p>
        <table>
            <thead>
            <th>Produkt</th>
            <th>Ilość</th>
            <th>Zmień</th>
            </thead>
            <?php $productOrders = ProductsOrder::findByOrderID($order->id); ?>
            <?php foreach ($productOrders as $productOrder) : ?>
                <form method="post">
                <tbody>
                <div class="form-group">
                    <td>
                        <label for="product"><?php echo Product::findById($productOrder->product_id)->name . Volume::findById($productOrder->volume_id)->volume; ?>
                            :</label></td>
                    <input hidden name="id" value="<?php echo $productOrder->id; ?>">
                    <td><input class="form-control" type="number" name="amount" id="product"
                               maxlength="50" value="<?php echo $productOrder->amount; ?>"></td>
                    <td><button type="submit" name="editAmount">Zmień ilość</button> </td>
                </div>
                </tbody>
                </form>
            <?php endforeach; ?>
        </table>

    <form method="post">
        <!--Wiadomość zwrotna-->

        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" id="email" maxlength="50"
                   value="<?php echo $order->email; ?>">
        </div>

        <div class="form-group">
            <label for="firstname">Imię:</label>
            <input class="form-control" type="text" name="firstname" id="firstname" maxlength="30"
                   value="<?php echo $order->first_name; ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Nazwisko:</label>
            <input class="form-control" type="text" name="lastname" id="lastname" maxlength="30"
                   value="<?php echo $order->last_name; ?>">
        </div>

        <div class="form-group">
            <label for="street">Ulica:</label>
            <input class="form-control" type="text" name="street" id="street" maxlength="30"
                   value="<?php echo $order->street; ?>">
        </div>
        <div class="form-group">
            <label for="housenumber">Numer domu:</label>
            <input class="form-control" type="text" name="housenumber" id="housenumber" maxlength="30"
                   value="<?php echo $order->house_number; ?>">
        </div>
        <div class="form-group">
            <label for="post_code">Kod pocztowy:</label>
            <input class="form-control" type="text" name="post_code" id="post_code" maxlength="30"
                   value="<?php echo $order->post_code; ?>">
        </div>
        <div class="form-group">
            <label for="town">Miasto:</label>
            <input class="form-control" type="text" name="town" id="town" maxlength="30"
                   value="<?php echo $order->town; ?>">
        </div>


        <button class="btn btn-sipp pull-right" name="changeOrder" type="submit">Zmień zamówienie</button>

    </form>
</div>


<!--javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
    $('a').tooltip();
</script>