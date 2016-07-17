<?php
    $pagename = "Home page";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
        $message = 1;
        $_SESSION['success'] = 0;
    }

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
            <h1>Home Page</h1>
            <?php
                echo '<p class="artcat-detail">Ultimi arrivi</p>';
                echo '<div id="container"><span class="stretch"></span>';
                $artsset = mysql_query("SELECT * FROM articles ORDER BY id DESC LIMIT 8");
                while ($articles = mysql_fetch_array($artsset)) {
                    show_article_thumb($articles);
                }
                echo '<span class="stretch"></span>';
                echo '<p class="artcat-detail">Offerte</p>';
                echo '<span class="stretch"></span>';
                $artsset = mysql_query("SELECT * FROM articles ORDER BY price LIMIT 8");
                while ($articles = mysql_fetch_array($artsset)) {
                    show_article_thumb($articles);
                }
            ?>
                <span class="stretch"></span></div>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
