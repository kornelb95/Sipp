<div class="row">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                <span class="sr-only">Nawigacja</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="main.php">Strona Główna</a></li>
                <li><a href="kubki.php">Kubki</a></li>
                <li><a href="#">Promocje</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
            </ul>

            <ul class="nav navbar-nav icon-menu navbar-right" id="navbar-right">
                <li><a href="#">Moje zamówienia</a></li>
                <li class="dropdown"><a href="#" data-toggle="dropdown"><?php echo User::findById($_SESSION['user_id'])->username; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Ustawienia</a></li>
                        <li><a href="logout.php">Wyloguj</a></li>
                    </ul>
                </li>
                <li id="nav-cart"> <a href="cart.php" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> <span id="nav-cart-count"></span></a></li>
            </ul>
        </div>
    </nav>
</div>