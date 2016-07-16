<?php
    $pagename = "Accesso";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    // Se l'utente ha già effettuato l'accesso, rimandalo alla home page
    if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
        header("Location: index.php");
        exit;
    }

    $error = 0;
    $message = 0;

    if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
        $message = 1;
        $_SESSION['success'] = 0;
    }

    // Verifica richiesta di login
    if (isset($_POST['email']) && !empty($_POST['email']) && (!isset($_POST['password']) || empty($_POST['password'])))
            $error = 2;
    if (isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])) {
        $email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
        $password = mysql_real_escape_string(md5(htmlspecialchars(trim($_POST['password'])).$salt));
        
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $res = mysql_query($query) or die("<br><br><br>Impossibile completare l'operazione");
        
        if (mysql_num_rows($res)>0) {
            // Login effettuato con successo
            $_SESSION['status'] = 1;
            $_SESSION['success'] = 1;
            $_SESSION['error'] = 0;
            $_SESSION['id'] = mysql_result($res,0,'id');
            $_SESSION['fullname'] = mysql_result($res,0,'firstname')." ".mysql_result($res,0,'lastname');
            $_SESSION['admin'] = mysql_result($res,0,'isAdmin');
            $res = mysql_result($res,0,'id');
            $res = mysql_num_rows(mysql_query("SELECT * FROM carts WHERE idUser=".$res));
            $_SESSION['cartno'] = $res;
            header("Location: index.php");
            exit;
        } else {
            // Login fallito
            $_SESSION['status'] = 0;
            $error = 1;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Accesso</h1>
            <?php
                // Errore di accesso
                if (isset($error) && ($error == 1))
                    echo '<div id="box-error"><span>Errore durante l\'accesso</span><p>L\'
                    indirizzo e-mail o la password inseriti non sono validi.</p></div>';
                if (isset($error) && ($error == 2))
                    echo '<div id="box-error"><span>Errore durante l\'accesso</span><p>Devi compilare tutti i campi di testo.</p></div>';
                if (isset($message) && ($message == 1))
                    echo '<div id="box-message"><span>Registrazione completata</span><p>Adesso puoi inserire le tue credenziali per effettuare l\'accesso.</p></div>';
            ?>
            <form method="post">
                <div>
                    <h4>Informazioni account</h4>
                    <p><label>Indirizzo e-mail:</label><input type="email" name="email" placeholder="indirizzo@esempio.it"></p>
                    <p><label>Password:</label><input type="password" name="password" placeholder="Password"></p><br>
                </div>
                <span><input type="submit" value="Accedi"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
