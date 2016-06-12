<div id="navbar">
    <a id="logo" href="./index.php" title="Home page">
        <img src="./public/res/logo.png"/>
        <p>eCommerce</p>
    </a>
    <ul>
        <?php
            if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
                echo '<a href="./check.php" title="Carrello"><li class="navbutton">Carrello</li></a>';
                echo '<li id="profile-menu" class="navbutton">'.$_SESSION['firstname'].'</li>';
            }
            else {
                echo '<a href="./login.php" title="Accedi"><li class="navbutton">Accedi</li></a>';
                echo '<a href="./signup.php" title="Registrati"><li class="navbutton">Registrati</li></a>';
            }
        ?>
        <div style="width: 20px; float:right;" class="ver-bar"></div>
    </ul>
</div>
