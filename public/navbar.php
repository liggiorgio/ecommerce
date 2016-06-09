<div id="navbar">
    <a id="logo" href="./index.php" title="Home page">
        <img src="./public/res/logo.png"/>
        <p>eCommerce</p>
    </a>
    <ul>
        <?php
            if (isset($_SESSION['username']) && ($_SESSION['logged']==true)) {
                echo '<a><li class="navbutton">Profilo</li></a>';
                echo '<a><li class="navbutton">Carrello</li></a>';
            }
            else {
                echo '<a href="./login.php" title="Accedi"><li class="navbutton">Accedi</li></a>';
                echo '<a href="./signup.php" title="Registrati"><li class="navbutton">Registrati</li></a>';
            }
        ?>
        <div style="width: 20px; float:right;" class="ver-bar"></div>
    </ul>
</div>
