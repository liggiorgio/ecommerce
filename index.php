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
            
                echo '<div id="arts-container"><span class="stretch"></span>';
                    $artsset = mysql_query("SELECT * FROM articles ORDER BY cat");
                    while ($articles = mysql_fetch_array($artsset)) {
                        echo '<a class="article" title="Clicca per i dettagli"><img src="'.$articles['thumb'].'"/><br><span class="price">'.$articles['price'].'€</span><span class="amount">Disponibili: '.$articles['amount'].'</span><br><br><span class="artname">'.$articles['name'].'</span></a>';
                    }
                echo '<span class="stretch"></span></div>';
            ?>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
