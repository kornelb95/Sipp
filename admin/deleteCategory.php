
<?php
require_once '../includes/init.php';

if(!$session->isSignedInAdmin()){
    header("Location: index.php");
}


if(empty($_GET['id'])){
    header("Location: addCategory.php");
}

$category = Category::findById($_GET['id']);

if($category->delete()){
    $session->message("Kategoria " . $category->category . " została usunięta pomyślnie");
//    $category->delete();
    header("Location: addCategory.php");
} else {
    header("Location: addCategory.php");
}