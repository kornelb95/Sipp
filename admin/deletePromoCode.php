
<?php
require_once '../includes/init.php';

if(!$session->isSignedInAdmin()){
    header("Location: index.php");
    die;
}


if(empty($_GET['id'])){
    header("Location: promoCodes.php");
    die;
}

$promoCodes = DiscountCodes::findById($_GET['id']);

$promoCodes->delete();
$session->message("Kod rabatowy " . $promoCodes->code . " został usunięty pomyślnie");
header("Location: promoCodes.php");
