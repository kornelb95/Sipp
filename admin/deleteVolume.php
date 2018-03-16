
<?php
require_once '../includes/init.php';

if(!$session->isSignedInAdmin()){
    header("Location: index.php");
}


if(empty($_GET['id'])){
    header("Location: addVolume.php");
}

$volume = Volume::findById($_GET['id']);

if($volume->delete()){
    $session->message("Pojemność " . $volume->volume . " została usunięta pomyślnie");
//    $category->delete();
    header("Location: addVolume.php");
} else {
    header("Location: addVolume.php");
}