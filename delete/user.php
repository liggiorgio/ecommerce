<?php
    $pagename = "Rimuovi utente";
    include_once("../config.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }

    // Se l'utente non è un amministratore, riporta alla pagina iniziale
    if (!isset($_SESSION['admin']) || ($_SESSION['admin'] == 0)) {
        header("Location: /index.php");
        exit;
    }

    if (!isset($_POST['user']) || empty($_POST['user'])) {
        header("Location: /administration.php");
        exit;
    } else {
        $error = 0;
        $user = mysql_real_escape_string(htmlspecialchars(trim($_POST['user'])));
        $query = "DELETE FROM users WHERE users.id = $user";
        $res = mysql_query($query) or ($error = 1);
        
        if ($error==0) {
            $_SESSION['success'] = 1;
            header("Location: /administration.php");
            exit;
        } else {
            $pagename = "Amministrazione";
            include_once("../public/header.php");
            include_once("../public/navbar.php");
            echo '<div id="wrapper">
                <div id="space-up"></div>
            
                    <!--- Page content --->
                    <h1>Rimuovi utente</h1>
                    <div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    portare a termine l\'operazione, riprova più tardi.</p></div>
                    <div id="space-down"></div>
                </div>';
            include_once("./public/footer.php");
            echo '</body>
                </html>';
        }
    }
?>