<?php require_once '../includes/init.php'; ?>
<?php if(!$session->isSignedInAdmin()) {header("Location: index.php");} ?>
<?php
$users = User::findAll();
if(isset($_GET['user_id'])) {
    $user = User::findById($_GET['user_id']);
    $user->delete();
    $session->message("Pomyslnie usunięto uzytkownika");
    header("Location: users.php");
}
?>
<?php require_once 'includes/header_admin.php' ?>
<?php require_once 'includes/navbar_admin.php' ?>


<!-- wyszukiwanie -->
<hr>

<div class="container-fluid">
    <a href="adduser.php" class="btn btn-sipp"><span class="glyphicon glyphicon-plus-sign"> Dodaj Użytkownika</span></a>
</div>

<hr>

<div class="container-fluid">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">

            <label>Wyszukiwanie tekstowe</label>
            <div class="form-group">
                <input class="form-control" type="text" name="liveSearch2" id="liveSearch2" placeholder="Szukana fraza">
            </div>
    </div>
</div>

<hr>


<!-- Tabela z zamówieniami-->


<div class="container-fluid">
   <p class="bg-success"><?php echo $message; ?></p>
    <table class="table table-bordered table-responsive" id="usersTable">
        
        <thead>
            <tr>
                <th>#</th>
                <th>Login</th>
                <th>Email</th>
                <th>Ilość zamówień</th>
                <th>Data ostatniego zamówienia</th>
                <th>&nbsp;<!--Zmiany w userze--></th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo User::countOrders($user->id);   ?></td>
                <td><?php echo Orders::lastOrder($user->id)->date; ?></td>
                <td><a href="../admin/userEdit.php" class="btn btn-sipp">Edytuj</a><a href="users.php?user_id=<?php echo $user->id; ?>" class="btn btn-sipp-inverse">Usuń</a></td>
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