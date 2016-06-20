<?php
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    function show_article_thumb($articles) {
        if ($articles['amount'] > 15) {
            echo '<a class="article" title="Clicca per dettaglio articolo"><img src="./public/res/articles/'.$articles['id'].'.png"/><br><span class="price">'.$articles['price'].'€</span><span class="amount-available">Q.tà: '.$articles['amount'].'</span><br><br><span class="artname">'.substr($articles['name'],0,77);
            if (strlen($articles['name']) > 77) {
                echo '...';
            }
            echo '</span></a>';
        } elseif ($articles['amount'] > 0) {
            echo '<a class="article" title="Clicca per dettaglio articolo"><img src="./public/res/articles/'.$articles['id'].'.png"/><br><span class="price">'.$articles['price'].'€</span><span class="amount-limited">Q.tà: '.$articles['amount'].'</span><br><br><span class="artname">'.substr($articles['name'],0,77);
            if (strlen($articles['name']) > 77) {
                echo '...';
            }
            echo '</span></a>';
        } else {
            echo '<a class="article" title="Clicca per dettaglio articolo"><img src="./public/res/articles/'.$articles['id'].'.png"/><br><span class="price">'.$articles['price'].'€</span><span class="amount-ended">N/D</span><br><br><span class="artname">'.substr($articles['name'],0,77);
            if (strlen($articles['name']) > 77) {
                echo '...';
            }
            echo '</span></a>';
        }
    }
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
                        show_article_thumb($articles);
                    }
                echo '<span class="stretch"></span></div>';
            ?>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
