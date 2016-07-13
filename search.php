<?php
    $pagename = "Ricerca articolo";
    include_once("./config.php");

    $my_cat = "*";

    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $error = 0;
        $my_query = $_GET['query'];
        $my_cat = $_GET['cat'];
    } else {
        if (isset($_GET['query']) && empty($_GET['query'])) {
            $error = 1;
        }
    }

    include_once("./public/header.php");
    include_once("./public/navbar.php");

    if (!empty($_GET['cat'])) {
        $currentcat = mysql_fetch_array(mysql_query("SELECT name FROM categories WHERE id=".$my_cat));
        $currentcat = $currentcat['name'];
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
            <h1>Ricerca articolo</h1>
            <?php
                // Errore di accesso
                if (isset($error) && ($error == 1))
                    echo '<div id="box-error"><span>Errore di ricerca</span><p>Non hai specificato alcun termine di ricerca.</p></div>';
            ?>
            <form method="get">
                <div style="width: 60%;">
                    <h4>Cerca un articolo nel catalogo, specificando i filtri di ricerca.</h4>
                    <p><input style="width: 400px;" type="text" name="query" title="Inserisci i termini di ricerca" placeholder="Cosa stai cercando?"/></p>
                    <p><select style="width: 250px" name="cat">
                        <option value="">In tutte le categorie</option>
                        <?php
                            $catsset = mysql_query("SELECT * FROM categories ORDER BY name");
                            while ($cats = mysql_fetch_array($catsset)) {
                                echo "<option value=\"".$cats['id']."\">".$cats['name']."</option>";
                            }
                        ?>
                        </select><button type="submit" style="margin-left: 70px;">Cerca</button></p>
                </div>
            </form>
            <div><span class="stretch"></span></div>
            
            <?php
                if (isset($_GET['query']) && !empty($_GET['query']) && ($error==0)) {
                    if (!empty($_GET['cat']))
                        {$artsset = mysql_query("SELECT * FROM articles WHERE cat=".$my_cat." AND name LIKE '%".$my_query."%'"); $currentcat = ' nella categoria "'.$currentcat.'"';}
                    else
                        {$artsset = mysql_query("SELECT * FROM articles WHERE name LIKE '%".$my_query."%'"); $currentcat = ' in tutte le categorie';}
                    echo '<p class="artcat-detail">Ricerca di "'.$my_query.'" '.$currentcat.'</p>';            
                    echo '<div id="container"><span class="stretch"></span>';
                    if (mysql_num_rows($artsset)>0) {
                        while ($articles = mysql_fetch_array($artsset)) {
                            show_article_thumb($articles);
                        }
                    } else {
                        echo '<h3>Nessun articolo soddisfa i criteri di ricerca.</h3>';
                    }
                }
            ?>
            <span class="stretch"></span></div>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
