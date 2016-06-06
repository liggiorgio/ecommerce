<?php
    include_once("./config.php");

    if (isset($_SESSION[id])&&($_SESSION['logged']==true))
        header("./dashboard.php");

    include_once("./public/header.php");
    include_once("./public/navbar.php");
?>
        <div id="wrapper">
            <p>Ciaone!</p>
        </div>
    </body>
</html>
