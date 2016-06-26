<?php
    include_once("../config.php");
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: /categories.php");
        exit;
    } else {
        $my_id = $_GET['id'];
    }
    $currentcat = mysql_fetch_array(mysql_query("SELECT name FROM categories WHERE id=".$my_id));
    $currentcat = $currentcat['name'];
    $pagename = $currentcat;
    include_once("../public/header.php");
    include_once("../public/navbar.php");

    function show_article_thumb($articles) {
        echo '<a class="article" title="Clicca per dettaglio articolo" href="/view/article.php?id='.$articles['id'].'"><img src="/public/res/articles/'.$articles['id'].'.jpg"/><br><span class="price">'.$articles['price'].'€</span>';
        
        if ($articles['amount'] > 15) {
            echo '<span class="amount-available">Q.tà: '.$articles['amount'];
        } elseif ($articles['amount'] > 5) {
            echo '<span class="amount-limited">Q.tà: '.$articles['amount'];
        } elseif ($articles['amount'] > 0) {
            echo '<span class="amount-last">Q.tà: '.$articles['amount'];
        } else {
            echo '<span class="amount-ended">N/D';
        }
        
        echo '</span><br><br><span class="artname">'.substr($articles['name'],0,77);
        if (strlen($articles['name']) > 77) { echo '...'; }
        echo '</span></a>';
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Esplora la categoria</h1>
            <?php
                echo '<p class="artcat-detail">Articoli nella categoria "'.$currentcat.'"</p>';            
                echo '<div id="container"><span class="stretch"></span>';
                    $artsset = mysql_query("SELECT * FROM articles WHERE cat=".$my_id);
                    if (mysql_num_rows($artsset)>0) {
                        while ($articles = mysql_fetch_array($artsset)) {
                            show_article_thumb($articles);
                        }
                    } else {
                        echo '<h3>Non sono ancora presenti articoli in questa categoria.</h3>';
                    }      
            ?>
                <span class="stretch"></span></div>
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
