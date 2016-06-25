<?php
    $pagename = "Categorie";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Categorie</h1>
            <p>Esplora i prodotti navigando per categoria di articoli.</p>
            <?php
                echo '<div id="container"><span class="stretch"></span>';
                    $catsset = mysql_query("SELECT * FROM categories ORDER BY id");
                while ($categories = mysql_fetch_array($catsset)) {
                    echo '<a class="category" href="./browsecategory.php?id='.$categories['id'].'" title="Esplora articoli in '.$categories['name'].'">
                    <span class="catname">'.$categories['name'].'</span>
                    <img src="./public/res/categories/'.$categories['id'].'.jpg">
                    <span class="catdescr">'.$categories['descr'].'</span></a>';
                }
            ?>
                <span class="stretch"></span></div>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
