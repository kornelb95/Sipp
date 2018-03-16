<?php require_once 'includes/init.php';
$products = Product::findAll();
$discountCodes = DiscountCodes::findAll();

foreach ($discountCodes as $discountCode) {
    $date = $discountCode->date;
    $hour = substr($date, 11,2);
    $min = substr($date, 14,2);
    $sek = substr($date, 17,2);
    $year = substr($date, 0,4);
    $month = substr($date, 5,2);
    $day = substr($date, 8,2);
    $timestamp = mktime($hour, $min, $sek, $month, $day, $year);
    if(time() > $timestamp) {
        $discountCode->active = "NIE";
        $discountCode->save();
    }
}

foreach ($products as $product) {
//    if(time() > $product->end_date) {
//
//    }
    if($product->type == "limitted"){

        $date = $product->end_date;
        $hour = substr($date, 11,2);
        $min = substr($date, 14,2);
        $sek = substr($date, 17,2);
        $year = substr($date, 0,4);
        $month = substr($date, 5,2);
        $day = substr($date, 8,2);
        $timestamp = mktime($hour, $min, $sek, $month, $day, $year);
        if(time() > $timestamp) {
            $product->status = "niewidoczny";
            $product->save();
        }
    }

}