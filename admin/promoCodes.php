<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php

$discountCodes = DiscountCodes::findAll();
$groups = DiscountCodesGroups::findAll();
if (isset($_POST['searchbygroup'])) {
    $group_id = isset($_POST['groups']) && $_POST['groups'] != 'nooption' ? $_POST['groups'] : null;
    if ($group_id == null) {
        $session->errorMessage("Nie zaznaczono opcji wyszukiwania");
        header("Location: promoCodes.php");
    } else {
        $group = DiscountCodesGroups::findById($group_id);
    }

}
if(isset($_POST['searchbycode'])) {
    $code = DiscountCodes::findByCode($_POST['code']);
    if($code == null) {
        $session->errorMessage("Nie znaleziono takiego kodu");
        header("Location: promoCodes.php");
    }
}
if (isset($_POST['searchprices'])) {
    $discountCodes = DiscountCodes::findPrices();
}
if (isset($_POST['searchdiscounts'])) {
    $discountCodes = DiscountCodes::findDiscounts();
}
if (isset($_POST['searchfreedelivery'])) {
    $discountCodes = DiscountCodes::findFreeDelivery();
}

if(!empty($group)) {
    $discountCodes = DiscountCodes::findByGroupId($group->id);
}
if (!is_null($code)) {
    $discountCodes = $code;
}
if(isset($_POST['showall'])) {
    $discountCodes = DiscountCodes::findAll();
}
if (isset($_POST['searchactive'])) {
    $discountCodes = DiscountCodes::findActives();
}




?>
<?php require_once 'includes/header_admin.php'; ?>
<?php require_once 'includes/navbar_admin.php'; ?>


<div class="container-fluid">
    <hr>
    
    <div class="col-lg-4 push-lg-1">
        <div class="row">
            <a href="../admin/addPromoCode.php" class="btn btn-sipp">Dodaj kod</a>
            <a href="../admin/editGroup.php" class="btn btn-sipp">Edytuj grupy</a>
        </div>
        <hr>
        <h3>Wyszukiwanie</h3>


        <div class="container-fluid">
            <div class="col-lg-6 push-lg-1">
                <div class="row">
                    <form method="post">
                        <button name="showall" class="btn btn-sipp">Wszystkie</button>
                        <button name="searchdiscounts" class="btn btn-sipp">Rabaty</button>
                        <button name="searchprices" class="btn btn-sipp">Cenniki</button>
                        <button name="searchfreedelivery" class="btn btn-sipp">Darmowa dostawa</button>
                        <button name="searchactive" class="btn btn-sipp">Aktywne</button>
                    </form>
                </div>
            </div>
        </div>
        <form method="post">
            <label>Grupa</label> <!--Grupy kodów, używane tylko dla nas, segregujące i ułatwiające nawigację w kodach rabatowych-->
            <select class="form-control" name="groups" id="group">
                <option value="nooption">Wybierz:</option>
                <?php foreach ($groups as $group): ?>
                <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sipp pull-right" type="submit" name="searchbygroup">Szukaj</button>
        </form>
            <hr>
        <form method="post">
            <label>Kod rabatowy</label>
            <div class="form-group">
                <input class="form-control" type="text" name="code" id="code">
            </div>
            <button class="btn btn-sipp pull-right" type="submit" name="searchbycode">Szukaj</button>
        </form>

        
    </div>
</div>

<div class="container-fluid">
    <hr>
    <!--Wiadomość zwrotna-->
    <p class="bg-success"><?php echo $message; ?></p>
    <p class="bg-danger"><?php echo $errorMessage; ?></p>
    <table class="table table-bordered table-responsive">
        
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>L.p.</th>
                <th>Kod</th>
                <th>Grupa</th>  <!--zniżka %, zniżka kwota, dostawa gratis, newsletter-->
                <th>Produkty</th> <!--wybór kategorii, albo poszczególnych produktów-->
                <th>Rabat/Cennik</th>
                <th>Ilość</th>  <!--w przypadku, kiedy kod jest rozsyłany do większej ilości osób, i liczba zdolnych do wykorzystania kodów jest ograniczona-->
                <th>Ważny do</th>
                <th>Aktywny</th>
                <th>Darmowa dostawa</th>
                <th>Edycja</th>
            </tr>
        </thead>
        
        <tbody>
        <?php foreach ($discountCodes as $discountCode):?>
            <tr>
                <td><input type="checkbox"></td>
                <td><?php echo $discountCode->id; ?></td>
                <td><?php echo $discountCode->code; ?></td>
                <td><?php echo DiscountCodesGroups::findById($discountCode->group_id)->name; ?></td>
                <td>
                    <?php $codesVolumes = CodesVolumes::findByCodesId($discountCode->id);
                          foreach ($codesVolumes as $codesVolume) {
                              echo Volume::findById($codesVolume->volume_id)->volume . " ml<br>";
                          }

                    ?>
                </td>
                <td>
                    <?php echo !is_null($discountCode->discount) ? $discountCode->discount . '%' : ''; ?>
                    <?php echo !is_null($discountCode->prices_id) ? Prices::findById($discountCode->prices_id)->name : ''; ?>
                </td>
                <td></td>
                <td><?php echo $discountCode->date; ?></td>
                <td><?php echo $discountCode->active; ?></td>
                <td>
                    <?php
                        if(!is_null($discountCode->freedelivery)) {
                            echo "TAK";
                        } else {
                            echo "NIE";
                        }
                    ?>
                </td>
                <td>
                    <div class="pull-right"><a href="#" class="btn btn-sipp">Edytuj</a></div><div class="pull-right"><a href="deletePromoCode.php?id=<?php echo $discountCode->id; ?>" name="delete" class="btn btn-sipp">Usuń</a></div>
                </td>

            </tr>
            <?php endforeach; ?>

            
        </tbody>
    
    </table>

</div>

<!--To coś na dole do nawigacji--> 

<nav aria-label="Page navigation">
    
    <ul class="pagination pull-right">
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
        <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
  </ul>
</nav>


<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script src="script.js"></script>
