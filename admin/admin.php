<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$products = Product::findAll();
$volumes = Volume::findAll();
$orders = Orders::findAll();
if(isset($_POST['changeStatus'])) {
    foreach ($_POST['check'] as $check) {
        $order = Orders::findById($check);
        $order->status = $_POST['status'];
        $order->save();
        $session->message("Pomyślnie zmieniono status");
        header("Location: admin.php");
    }
}
if(isset($_POST['searchByDate'])) {
    if (!empty($_POST['from']) && !empty($_POST['to'])) {
        $orders = Orders::findBetweenDate($_POST['from'], $_POST['to']);
    }
}
if (isset($_POST['searchProduct'])) {
    $product_id = $_POST['product'] == "nooption" ? 'nooption' : $_POST['product'];
    $volume_id = $_POST['volume'] == "nooption" ? 'nooption' : $_POST['volume'];
//    print_r($volume_id);
//    print_r($product_id);
//    die;

    $order_array = ProductsOrder::findOrderIdByProductAndVolume($product_id, $volume_id);


    $orders = [];
    foreach ($order_array as $order) {

            $orders[] = Orders::findById($order->order_id);

    }
}
if(isset($_POST['showAll'])) {
    $orders = Orders::findAll();
}
if(isset($_POST['showLimitted'])) {
   $products = Product::findLimitted();

   $productsOrders = [];
   foreach ($products as $product) {
           $OrderIds[] = array_shift(ProductsOrder::findByProductId($product->id))->order_id;
   }


   $orders = [];

    foreach ($OrderIds as $OrderId) {

        $orders[] = Orders::findById($OrderId);
        if(empty($orders[$i])) {
            unset($orders[$i]);
        }
        $i++;
   }

}
if(isset($_POST['showShops'])) {
    $products = Product::findShop();

    $productsOrders = [];
    foreach ($products as $product) {
        $OrderIds[] = array_shift(ProductsOrder::findByProductId($product->id))->order_id;
    }


    $orders = [];
    $i = 0;
    foreach ($OrderIds as $OrderId) {

        $orders[] = Orders::findById($OrderId);
        if(empty($orders[$i])) {
            unset($orders[$i]);
        }
        $i++;
    }

}
?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>


<!-- Dodawanie zamówienia oraz wyszukiwanie -->

<hr>

<div class="container-fluid">
    <button class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign"> Dodaj zamówienie</span></button>
</div>

<hr>

<div class="container-fluid odstep-gora-1">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
        

            <label>Wyszukiwanie tekstowe</label>
            <div class="form-group">
                <input class="form-control" type="text" name="liveSearch" id="liveSearch" placeholder="Wpisz szukaną frazę">
            </div>
        <form method="post">
            <label>Data</label>
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" type="date" name="from" id="from">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" type="date" name="to" id="to">
                    </div>
                </div>
            
            </div>
            <button type="submit" class="btn btn-sipp-inverse pull-left" name="searchByDate">Wyszukaj</button>
        </form>
    
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
        
        <form method="post" id="search-form2">
            
            <label>Projekt</label>
            <select class="form-control" name="product" id="project">
                <option value="nooption">Wybierz:</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
                <?php endforeach; ?>
            </select>
            
            <hr>
            
            <label>Pojemność</label>
            <select class="form-control" name="volume" id="pojemnosc">
                <option value="nooption">Wybierz:</option>
                <?php foreach ($volumes as $volume): ?>
                <option value="<?php echo $volume->id; ?>"><?php echo $volume->volume; ?> ml</option>
                <?php endforeach; ?>
            </select>
            
            <hr>
            
            <button class="btn btn-sipp-inverse pull-left" name="searchProduct" type="submit">Wyszukaj</button>
    
        </form>
    
    </div>
</div>

<hr>

<!--pryciski formatujące tabelę według typu zamówień-->

<div class="container-fluid">
    <div class="col-lg-6 push-lg-1">
        <div class="row">
            <form method="post">
                <button type="submit" name="showAll" class="btn btn-sipp">Wszystkie</button>
                <button type="submit" name="showLimitted" class="btn btn-sipp">Limited</button>
                <button type="submit" name="showShops" class="btn btn-sipp">Sklep</button>
            </form>
        </div>
    </div>
</div>

<hr>
<!--zmiana statusu, status zmienia się od razu po kliknięciu - bez żadnego buttona-->

<div class="container-fluid">
    <div class="col-lg-6 push-lg-1">
        <strong>Zmiana statusu: </strong>
         <select name="status">
            <option value="Oczekiwanie na płatność" style="background-color: #caebfb">Oczekiwanie na płatność</option>
            <option value="Płatność zaakceptowana" style="background-color: #ddffa6"> Płatność zaakceptowana</option>
            <option value="Wysłane">Wysłane</option>
            <option value="Anulowane" style="background-color: #f6c1c1">Anulowane</option>
        </select>
    </div>
</div>


<!-- Tabela z zamówieniami-->
<p class="bg-success"><?php echo $message; ?></p>
<div class="container-fluid">
    <form method="post">
    <table class="table table-bordered table-responsive" id="ordersTable">
        <thead>

            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Id</th>
                <th>Użytkownik</th>
                <th>Imię i nazwisko</th>
                <th>Data</th>
                <th>Status
                    <!--
                    <select name="status">
                        <option value="Oczekiwanie na płatność" style="background-color: #caebfb">Oczekiwanie na płatność</option>
                        <option value="Płatność zaakceptowana" style="background-color: #ddffa6"> Płatność zaakceptowana</option>
                        <option value="Wysłane">Wysłane</option>
                        <option value="Anulowane" style="background-color: #f6c1c1">Anulowane</option>
                    </select>
                    <button type="submit" name="changeStatus">Zmień status</button>
                    -->
                    
                    <!--Tu będzie ROZWIJANA lista wielokrotnego wyboru, jak ogarnę jak to w ogóle zrobić-->
                </th>
                <th>Wartość</th>
                <th>Ilość/Wzór/Pojemność</th>
                <th>Sposób wysyłki</th>
                <th>Adres</th>
                <th>Email</th>
                <th>Sposób płatności</th>
                <th>Edycja<!--Zmiana statusu oraz podgląd zamówienia--></th>
            </tr>
        </thead>
        
        <tbody>

            <?php foreach ($orders as $order) : ?>

            <tr data-toggle="collapse" data-target="#row<?php echo $order->id; ?>" class="accordion-toggle"  id="<?php echo str_replace(' ', '', $order->status); ?>">
                <td><input type="checkbox" name="check[]" value="<?php echo $order->id; ?>"></td>
                <td><?php echo $order->id; ?></td>
                <td><?php echo is_null($order->user_id) ? "Niezarejestrowany" : User::findById($order->user_id)->username; ?></td>
                <input name="id" hidden value="<?php echo $order->id; ?>">
                <td class="TdName"><?php echo $order->first_name . " " . $order->last_name; ?></td>
                <td><?php echo $order->date; ?></td>
                <td><?php echo $order->status; ?></td>
                <td><?php echo $order->totalcost; ?></td>
                <?php $productOrders = ProductsOrder::findByOrderID($order->id); ?>
                <td class="gallery">
                    <div class="rozwin"><span class="glyphicon glyphicon-option-horizontal"></span> Rozwiń...</div>
                    <div class="collapseProductList accordian-body collapse" id="row<?php echo $order->id; ?>">

                        <?php foreach ($productOrders as $productOrder) : ?>
                            <?php if(Product::findById($productOrder->product_id)) : ?>
                                <div class="thumbnail"><?php echo $productOrder->amount . "x " . Product::findById($productOrder->product_id)->name . "/" . Volume::findById($productOrder->volume_id)->volume; ?>
                                    <span><img width="200px" height="200px" src="<?php echo Product::findById($productOrder->product_id)->picture_path(); ?>" id="<?php echo Product::findById($productOrder->product_id)->picture_path(); ?>"></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>


                </td>
                <td><?php echo $order->send_method; ?></td>
                <td><?php echo $order->street . " " . $order->house_number . "<br>" . $order->post_code . " " . $order->town;?></td>
                <td><?php echo $order->email; ?></td>
                <td><?php echo $order->pay_method; ?></td>
                <td><a href="editorder.php?order_id=<?php echo $order->id; ?>" class="btn btn-sipp">Edytuj</a></td>
            </tr>
        <?php endforeach; ?>
            
        </tbody>
    
    </table>
    </form>
</div>

<!--To coś na dole do nawigacji--> 
<br><br><br><hr>
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
