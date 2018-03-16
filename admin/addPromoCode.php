<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$volumes = Volume::findAll();
$groups = DiscountCodesGroups::findAll();
$prices = Prices::findAll();
if (isset($_POST['addnewgroup'])) {
    $newgroup = new DiscountCodesGroups();
    $newgroup->name = !empty($_POST['addgroupcodes']) ? $_POST['addgroupcodes'] : $session->errorMessage("Nie wypełniono wszystkich pół");
    $newgroup->save() ? $session->message("Poprawnie dodano grupę kodów rabatowych") : $session->errorMessage("Niepowodzenie przy dodawaniu grupy");
    header("Location: addPromoCode.php");
}

if (isset($_POST['addDiscountCode'])) {
    $discountCode = new DiscountCodes();
    $discountCode->code = !empty($_POST['codename']) ? $_POST['codename'] : $session->errorMessage("Nie wypełniono wszystkich danych");
    $discountCode->group_id = !empty($_POST['groupcodes']) ? $_POST['groupcodes'] : $session->errorMessage("Nie wypełniono wszystkich danych");
    if (isset($_POST['discount']) && !empty($_POST['discount'])) {
        $discountCode->discount = !empty($_POST['discount']) ? $_POST['discount'] : $session->errorMessage("Nie podano wszystkich danych");
    } else {
        $discountCode->prices_id = !empty($_POST['prices']) ? $_POST['prices'] : $session->errorMessage("Nie podano wszystkich danych");
    }

    $discountCode->type = !empty($_POST['type']) ? $_POST['type'] : $session->errorMessage("Nie podano wszystkich danych");
    $discountCode->date = !empty($_POST['date']) ? $_POST['date'] : $session->errorMessage("Nie podano wszystkich danych");
    $discountCode->active = "TAK";
    $discountCode->freedelivery = isset($_POST['freedelivery']) ? "TAK" : null;
    $discountCode->save();
    if (!empty($_POST['volumes'])) {
        $volumes = $_POST['volumes'];

        foreach ($volumes as $volume) {
            $codesVolumes = new CodesVolumes();
            $codesVolumes->volume_id = $volume;
            $codesVolumes->codes_id = $discountCode->id;
            $codesVolumes->save() ? null : $session->errorMessage("Błąd zapisu codesvolumes do bazy");
        }
    }
    $session->message("Poprawnie dodano kod rabatowy");
    header("Location: addPromoCode.php");
}
?>
<?php require_once 'includes/header_admin.php'; ?>
<?php require_once 'includes/navbar_admin.php'; ?>

<div class="col-lg-4 col-lg-offset-4 odstep-gora-1">

        <form method="post" id="addCodesForm">
            <h4>
                Dodaj kod:
            </h4>

            <!--Wiadomość zwrotna-->
            <p class="bg-success"><?php echo $message; ?></p>
            <p class="bg-danger"><?php echo $errorMessage; ?></p>
            <div class="form-group">
                <label for="codename">Kod:</label>
                <input class="form-control" type="text" name="codename" id="codename" value="">
            </div>


            <div class="form-group">
                <label for="groupcodes">Grupa:</label>
                <select class="form-control" id="groupcodes" name="groupcodes">
                    <?php foreach ($groups as $group): ?>
                    <option value="<?php echo $group->id; ?>"><?php echo $group->name;  ?></option>
                    <?php endforeach;?>
                    <option value="newgroup">Nowa Grupa</option>
                </select>
            </div>
            <div class="form-group" hidden="hidden" id="addgroupcodes"> <!-- wyświetla się po zaznaczeniu nowa grupa -->
                <label for="addgroupcodes">Nazwa:</label>
                <input class="form-control" type="text" name="addgroupcodes" id="addgroupcodes" value="">
                <button class="btn btn-sipp" type="submit" name="addnewgroup">Dodaj grupę</button>
            </div>
            <div class="form-group">
                <label>Wybierz metodę:</label>
                <input type="checkbox" name="choosediscount" value="discount" id="choosediscount" class="checkmethod">
                <label for="discount">Rabat %</label>
                <input type="checkbox" name="chooseprices" value="prices" id="chooseprices" class="checkmethod">
                <label for="discount">Cennik</label>
            </div>

            <div class="form-group" id="discount" hidden="hidden">
                <label for="discount">Rabat:</label>
                <input type="number" step="0.5" max="100"  name="discount"> %
            </div>
            <div class="form-group" id="prices" hidden="hidden">
                <label for="prices">Wybierz cennik:</label>
                <select name="prices">
                    <?php foreach ($prices as $price): ?>
                    <option value="<?php echo $price->id; ?>"><?php echo $price->name; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="form-group">
                <input type="checkbox" name="freedelivery"> Darmowa dostawa
            </div>

            <div class="form-group">
                <label for="type">Typ:</label>
                <select name="type" id="type">
                    <option selected="selected" value="alltypes">Wszystkie typy</option>
                    <option value="shop">Sklep</option>
                    <option value="limitted">Limitowany</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Data zakończenia:</label>
                <input type="datetime-local" name="date">
            </div>
         
            <div class="form-group">
                <fieldset>
                    <legend>Wybierz produkty</legend>
                    <?php  foreach ($volumes as $volume): ?>
                    <div>
                        <input type="checkbox" name="volumes[]" value="<?php echo $volume->id; ?>">
                        <label><?php echo $volume->volume; ?> ml</label>
                    </div>
                    <?php endforeach;?>
                </fieldset>
            </div>
            
            
            <button class="btn btn-sipp pull-right" name="addDiscountCode" id="addDiscountCode" type="submit">Dodaj kod</button>

        </form>
    </div>


<!--javascript -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script >
<script src = "../js/bootstrap.min.js" ></script >
<script src="script.js"></script>