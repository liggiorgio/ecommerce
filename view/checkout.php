<?php
    $pagename = "Acquisto";
    include_once("../config.php");

    if (isset($_GET['purchase']) && ($_GET['purchase'] == 1)) {
        $_SESSION['success'] = 2;
        $_SESSION['cartno'] = 0;
    }
    
    if (isset($_SESSION['success']) && ($_SESSION['success'] == 2)) {
        $message = 2;
        $_SESSION['success'] = 0;
    }

    include_once("../public/header.php");
    include_once("../public/navbar.php");

    $subtotal = 0;
    $quantity = 0;
    $error = 0;
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Pagamento</h1>
            <?php
                if (isset($_GET['purchase']) && ($_GET['purchase']) == 1) {
                    $cartset = mysql_query("SELECT * FROM carts WHERE idUser=".$_SESSION['id']);
                    if (mysql_num_rows($cartset)>0) {
                        while ($cart = mysql_fetch_array($cartset)) {
                            $subtotal += mysql_result(mysql_query("SELECT price FROM articles, carts WHERE articles.id=".$cart['idArticle']),0,'price') or die();
                            $quantity += 1;
                            $res = mysql_query('UPDATE articles SET amount=(amount-1) WHERE id='.$cart['idArticle']);
                        }
                        $query = mysql_query("DELETE FROM carts WHERE idUser=".$_SESSION['id']);
                    }
                    // FATTURA
                    $query = mysql_query("INSERT INTO bills(idUser,total,descr) VALUES(".$_SESSION['id'].",".$subtotal.",".$quantity.")") or die();
                    
                    if (isset($message) && ($message == 2) && ($error==0))
                        echo '<div id="box-message"><span>Transazione completata</span><p>Grazie per aver completato l\'acquisto dei prodotti!</p></div><span class="stretch"></span>';
                    } else {
                        echo '<p>Rivedi le informazioni sulla spedizione</p>';
                        $cartset = mysql_query("SELECT articles.id AS id, carts.id AS cartId, name, price FROM articles,carts WHERE idUser=".$_SESSION['id']." AND idArticle=articles.id") or ($error = 1);
                        if (mysql_num_rows($cartset)>0) {
                        echo '<div id="cart-container">';
                        while ($cart = mysql_fetch_array($cartset)) {
                            $subtotal += $cart['price'];
                        }
                        $res = mysql_query("SELECT firstname, lastname, address, email, cities.name AS city, since FROM users, cities WHERE users.id=".$_SESSION['id']." AND users.city = cities.id");
                        $user = mysql_fetch_array($res);
                        echo '<span class="stretch"></span>
                        <div id="account-info">
                            <div class="user-info-table">
                                <p class="artcat-detail">Indirizzo di spedizione</p>
                                <div class="user-text">
                                    <p><b>Nome: </b>'.$user['firstname'].'</p>
                                    <p><b>Cognome: </b>'.$user['lastname'].'</p>
                                    <p><b>Indirizzo: </b>'.$user['address'].'</p>
                                    <p><b>Città: </b>'.$user['city'].'</p>
                                </div>
                            </div>

                            <span class="stretch"></span>';
                        echo '<p class="artcat-detail">Procedi con il pagamento</p><span class="stretch"></span>
                            <h3 style="float: left; margin-left: 50px;">Subtotale: '.$subtotal.'€</h3>
                            <a class="removefromcart" href="/view/checkout.php?purchase=1">Acquista</a>
                            <span class="stretch"></span></div></div>
                            ';
                    } else {
                        header("Location: /index.php");
                        exit;
                    }
                }
            ?>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
