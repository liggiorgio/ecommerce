<?php
    $pagename = "Aggiungi al carrello";
    include_once("./config.php");

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        header("Location: /index.php");
        exit;
    } else {
        $error = 0;
        $query = 'DELETE FROM carts WHERE id='.$_POST['id'];
        $res = mysql_query($query) or ($error = 1);
        
        if ($error==0) {
            $_SESSION['success'] = 2;
            $_SESSION['cartno'] -= 1;
            header("Location: /view/cart.php");
            exit;
        } else {
            $pagename = "Rimuovi dal carrello";
            include_once("./public/header.php");
            include_once("./public/navbar.php");
            echo '<div id="wrapper">
                <div id="space-up"></div>
            
                    <!--- Page content --->
                    <h1>Rimuovi dal carrello</h1>'.$_POST['id'].'
                    <div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    rimuovere il prodotto dal carrello, riprova più tardi.</p></div>
                    <div id="space-down"></div>
                </div>';
            include_once("./public/footer.php");
            echo '</body>
                </html>';
        }
    }
?>