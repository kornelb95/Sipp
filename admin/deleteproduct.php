
<?php
/**
 * Created by PhpStorm.
 * User: Kornel Błażek
 * Date: 17.02.2018
 * Time: 12:55
 */
require_once '../includes/init.php';
if(!$session->isSignedInAdmin()) {header("Location: index.php");}
$product = Product::findById($_GET['product_id']);
$product->delete();
header("Location: products.php");