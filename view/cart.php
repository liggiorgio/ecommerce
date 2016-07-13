<?php
    $pagename = "Carrello";
    include_once("../config.php");
    include_once("../public/header.php");
    include_once("../public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }

    if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
        $message = 1;
        $_SESSION['success'] = 0;
    }
    
    if (isset($_SESSION['success']) && ($_SESSION['success'] == 2)) {
        $message = 2;
        $_SESSION['success'] = 0;
    }
    $subtotal = 0;
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Il mio carrello</h1>
            <?php
                if (isset($message) && ($message == 1))
                    echo '<div id="box-message"><span>Operazione completata</span><p>Il prodotto è stato aggiunto al tuo carrello.</p></div><span class="stretch"></span>';
                if (isset($message) && ($message == 2))
                    echo '<div id="box-message"><span>Operazione completata</span><p>Il prodotto è stato rimosso dal tuo carrello.</p></div><span class="stretch"></span>';
                $cartset = mysql_query("SELECT articles.id AS id, carts.id AS cartId, name, price FROM articles,carts WHERE idUser=".$_SESSION['id']." AND idArticle=articles.id");
                if (mysql_num_rows($cartset)>0) {
                    echo '<p class="artcat-detail">Articoli attualmente presenti nel tuo carrello:</p><span class="stretch"></span>
                    <div id="cart-container">';
                    while ($cart = mysql_fetch_array($cartset)) {
                        $subtotal += $cart['price'];
                        echo '<a href="/view/article.php?id='.$cart['id'].'" class="cart-article"><img src="/public/res/articles/'.$cart['id'].'.jpg"/><p>'.$cart['name'].'</p><span class="price">'.$cart['price'].'€</span></a>
                        <form action="/removefromcart.php" method="post">
                            <input type="hidden" name="id" value="'.$cart['cartId'].'">
                            <button class="removefromcart" type="submit">Rimuovi</button>
                        </form><span class="stretch"></span>';
                    }
                    echo '<p class="artcat-detail">Procedi con l\'acquisto</p><span class="stretch"></span>
                        <h3 style="float: left; margin-left: 50px;">Subtotale: '.$subtotal.'€</h3>
                        <a class="addtocart" href="/view/checkout.php">Procedi con l\'acquisto</a>
                        <span class="stretch"></span></div>';
                } else {
                    echo '<h3>Il tuo carrello è vuoto!</h3>';
                }
            ?>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
