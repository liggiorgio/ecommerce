<div id="navbar">
    <a id="logo" href="./index.php" title="Home page">
        <img src="./public/res/logo.png"/>
        <p>eCommerce</p>
    </a>
    <ul>
        <?php
            if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
                echo '<a><li class="navbutton">Cerca</li></a>';
                echo '<a><li class="navbutton">Categorie</li></a>';
                echo '<li class="navbutton">Carrello (0)';
                    echo '<ul id="submenu-cart">';
                    echo '  <a><li class="navsubmenu">Visualizza carrello</li></a>';
                    echo '  <a><li class="navsubmenu">Completa acquisto</li></a>';
                    echo '</ul>';
                echo '</li>';
                echo '<li class="navbutton">'.$_SESSION['fullname'];
                    echo '<ul id="submenu-profile">';
                    echo '  <a><li class="navsubmenu">Dashboard</li></a>';
                    echo '  <a><li class="navsubmenu">Fatture</li></a>';
                    echo '  <a><li class="navsubmenu">Impostazioni</li></a>';
                    echo '  <a href="./logout.php"><li class="navsubmenu">Esci</li></a>';
                    echo '</ul>';
                echo '</li>';
            }
            else {
                echo '<a href="./login.php" title="Accedi"><li class="navbutton">Accedi</li></a>';
                echo '<a href="./signup.php" title="Registrati"><li class="navbutton">Registrati</li></a>';
            }
        ?>
        <div style="width: 20px; float:right;" class="ver-bar"></div>
    </ul>
</div>
