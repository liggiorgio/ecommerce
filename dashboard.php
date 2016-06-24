<?php
    $pagename = "Dashboard";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: login.php");
        exit;
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Dashboard</h1>
            <p>Visualizza e modifica il tuo profilo personale, e visualizza le tue attività recenti.</p>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
