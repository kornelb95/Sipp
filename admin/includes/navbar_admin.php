<div class="row">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                <span class="sr-only">Nawigacja</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                
                <li class="dropdown"><a href="#" data-toggle="dropdown">Zarządzanie stroną <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Układ <!--tu będą wszelkie kategorie w formacie drzewka--></a></li>
                        <li><a href="#">Dodatki <!--tutaj puste, ale na stówę się przyda do jakichś banerów itp.--></a></li>
                    </ul>
                </li>
                
                <li><a href="users.php">Użytkownicy</a></li>
                
                <li class="dropdown"><a href="#" data-toggle="dropdown">Sklep <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../admin/inventory.php">Stany magazynowe</a></li>
                        <li><a href=../admin/promoCodes.php>Kody rabatowe</a></li>
                        <li><a href="../admin/pricelist.php">Cenniki</a></li>
                    </ul>
                </li>
                
                <li><a href="admin.php">Zamówienia</a></li>
                <li><a href="products.php">Produkty</a></li>
            </ul>

            <ul class="nav navbar-nav icon-menu navbar-right" id="navbar-right">
                <li><a href="../index.php">Sipp</a></li>
                <li><a href="#">Ustawienia<!-- na razie puste--></a></li>
                <li><a href="logout.php">Wyloguj</a></li>
                <li><a href="#"><?php echo Admin::findById($_SESSION['admin_id'])->login; ?></a></li>
            </ul>
        </div>
    </nav>
</div>