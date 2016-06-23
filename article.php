<?php
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: index.php");
        exit;
    } else {
        $my_id = $_GET['id'];
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Dettagli articolo</h1>
            <?php
                $res = mysql_query("SELECT * FROM articles WHERE id = '$my_id'");
                if (mysql_num_rows($res)>0) {
                    $article = mysql_fetch_array($res);
                    echo '<p>'.$article['id'].'</p><br>
                        <p>'.$article['name'].'</p><br>
                        <p>'.$article['descr'].'</p><br>
                        <p>'.$article['price'].'</p><br>
                        <p>'.$article['amount'].'</p><br>
                        <p>'.$article['cat'].'</p><br>';
                } else {
                    echo '<p>L\'articolo non esiste!</p>';
                }
            ?>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
