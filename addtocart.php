<?php
    $pagename = "Aggiungi al carrello";
    include_once("./config.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        header("Location: /index.php");
        exit;
    } else {
        $error = 0;
        $query = 'INSERT INTO carts(idUser,idArticle) VALUES ('.$_SESSION['id'].','.$_POST['id'].')';
        $res = mysql_query($query) or ($error = 1);
        
        if ($error==0) {
            $_SESSION['success'] = 1;
            $_SESSION['cartno'] += 1;
            header("Location: /view/cart.php");
            exit;
        } else {
            $pagename = "Aggiungi al carrello";
            include_once("./public/header.php");
            include_once("./public/navbar.php");
            echo '<div id="wrapper">
                <div id="space-up"></div>
            
                    <!--- Page content --->
                    <h1>Aggiungi al carrello</h1>
                    <div id="box-error"><span>Errore durante l\'acquisto</span><p>Non è stato possibile
                    aggiungere il prodotto al carrello, riprova più tardi.</p></div>
                    <div id="space-down"></div>
                </div>';
            include_once("./public/footer.php");
            echo '</body>
                </html>';
        }
    }
?>