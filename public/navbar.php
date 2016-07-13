<div id="navbar">
    <a id="logo" href="/index.php" title="Home page">
        <img src="/public/res/logo.png"/>
        <p>eCommerce</p>
    </a>
    <ul>
        <?php
            echo '<a href="/search.php" title="Cerca un prodotto"><li class="navbutton">Cerca</li></a>
                <a href="/view/categories.php" title="Esplora le categorie"><li class="navbutton">Categorie</li></a>';
            if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
                echo '<li class="navbutton">Carrello ('.$_SESSION['cartno'].')
                    <ul id="submenu-cart">
                        <a href="/view/cart.php" title="Guarda gli articoli nel carrello"><li class="navsubmenu">Visualizza carrello</li></a>
                        <a href="/view/checkout.php" title="Effettua il pagamento"><li class="navsubmenu">Completa acquisti</li></a>
                    </ul>
                </li>
                <li class="navbutton">'.$_SESSION['fullname'].'
                    <ul id="submenu-profile">
                        <a href="/dashboard.php"><li class="navsubmenu">Dashboard</li></a>
                        <a href="/logout.php"><li class="navsubmenu">Esci</li></a>
                    </ul>
                </li>';
                }
            else {
                echo '<a href="/login.php" title="Accedi con un account"><li class="navbutton">Accedi</li></a>';
                echo '<a href="/signup.php" title="Registrati al sito"><li class="navbutton">Registrati</li></a>';
            }
        ?>
        <div class="ver-bar"></div>
    </ul>
</div>
