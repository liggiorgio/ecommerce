<div id="navbar">
    <a id="logo" href="./index.php" title="Home page">
        <img src="./public/res/logo.png"/>
        <p>eCommerce</p>
    </a>
    <ul>
        <?php
            if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
                echo '<a><li class="navbutton">Cerca</li></a>
                <a><li class="navbutton">Categorie</li></a>
                <li class="navbutton">Carrello (0)
                    <ul id="submenu-cart">
                        <a><li class="navsubmenu">Visualizza carrello</li></a>
                        <a><li class="navsubmenu">Completa acquisti</li></a>
                    </ul>
                </li>
                <li class="navbutton">'.$_SESSION['fullname'].'
                    <ul id="submenu-profile">
                        <a><li class="navsubmenu">Dashboard</li></a>
                        <a><li class="navsubmenu">Fatture</li></a>
                        <a><li class="navsubmenu">Impostazioni</li></a>
                        <a href="./logout.php"><li class="navsubmenu">Esci</li></a>
                    </ul>
                </li>';
                }
            else {
                echo '<a href="./login.php" title="Accedi"><li class="navbutton">Accedi</li></a>';
                echo '<a href="./signup.php" title="Registrati"><li class="navbutton">Registrati</li></a>';
            }
        ?>
        <div style="width: 20px; float:right;" class="ver-bar"></div>
    </ul>
</div>
