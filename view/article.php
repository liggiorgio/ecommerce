<?php
    include_once("../config.php");
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: /index.php");
        exit;
    } else {
        $my_id = $_GET['id'];
    }
    $res = mysql_query("SELECT articles.id AS id, articles.name AS name, articles.descr AS descr, cat, price, amount, categories.name AS catname FROM articles, categories WHERE articles.id = '$my_id' AND articles.cat = categories.id");
    if (mysql_num_rows($res)>0) {
        $article = mysql_fetch_array($res);
        $pagename = $article['name'];
        $error = 0;
    } else {
        $pagename = "Errore";
        $error = 1;
    }
    include_once("../public/header.php");
    include_once("../public/navbar.php");                        
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <?php
                if ($error == 0) {
                    // Visualizza dettagli articolo
                    echo '<h1>Dettaglio articolo</h1>
                          <div class="art-detail">
                            <p class="artname-detail">'.$article['name'].'</p>
                            <p class="artcat-detail">Categoria: <a href="/view/browsecategory.php?id='.$article['cat'].'" title="Esplora tutto in '.$article['catname'].'">'.$article['catname'].'</a></p><br>
                            <img src="/public/res/articles/'.$article['id'].'.jpg"/>';
                            echo '<div class="addtocart">[Placeholder]<br><a href="#">Aggiungi al carrello</a><br><br>[Placeholder]<br><a href="#">Acquista subito</a></div>';
                            echo '<br><p><span class="artlabel-detail">Prezzo:</span><br><span class="artprice-detail">'.$article['price'].'€</span></p>
                            <br><br><br><br><p><span class="artlabel-detail">Disponibilità:</span>';
                            if ($article['amount'] > 15) {
                                echo '<p class="artamount-detail-available">'.$article['amount'].' pezzi disponibili</p>';
                            } elseif ($article['amount'] > 5) {
                                echo '<p class="artamount-detail-limited">'.$article['amount'].' pezzi disponibili</p>';
                            } elseif ($article['amount'] > 0) {
                                echo '<p class="artamount-detail-last">'.$article['amount'].' pezzi disponibili</p>';
                            } else {
                                echo '<p class="artamount-detail-ended">Prodotto esaurito</p>';
                            }
                            echo '<span class="stretch"></span><h3>Descrizione</h3><p class="artdescr-detail">'.$article['descr'].'</p><br>
                        </div>';
                } else {
                    echo '<h1>Errore</h1><div id="box-error"><span>Errore del sistema</span><p>L\'articolo da voi richiesto non è presente nei database.</p></div>';
                }
            ?>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
