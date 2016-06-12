<?php
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Home Page</h1>
            <?php
                if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
                    echo '<p>Benvenuto, '.$_SESSION['fullname'].'!</p>';
                } else {
                    echo '<p>Benvenuto, ospite!</p>';
                }
            ?>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
