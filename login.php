<?php
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    // Se l'utente ha già effettuato l'accesso, rimandalo alla home page
    if (isset($_SESSION['status']) && ($_SESSION['status'] == 1)) {
        header("Location: index.php");
        exit;
    }

    if (!isset($_SESSION['error']))
        $_SESSION['error'] = 0;

    // Verifica richiesta di login
    if (isset($_POST['email']) && ($_POST['email'] != "") &&
        isset($_POST['password']) && ($_POST['password'] != "")) {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = md5(htmlspecialchars(trim($_POST['password'])).$salt);
        
        $query = "SELECT id, firstname, lastname FROM users WHERE email = '$email' AND password = '$password'";
        $res = mysql_query($query) or die("<br><br><br>Impossibile completare l'operazione");
        
        if (mysql_num_rows($res)>0) {
            // Login effettuato con successo
            $_SESSION['status'] = 1;
            $_SESSION['error'] = 0;
            $_SESSION['id'] = mysql_result($res,0,'id');
            $_SESSION['firstname'] = mysql_result($res,0,'firstname');
            $_SESSION['fullname'] = $_SESSION['firstname']." ".mysql_result($res,0,'lastname');
            header("Location: index.php");
            exit;
        } else {
            // Login fallito
            $_SESSION['status'] = 0;
            $_SESSION['error'] = 1;
            header("Location: login.php");
            exit;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Accesso</h1>
            <?php
                // Errore di accesso
                if (isset($_SESSION['error']) && ($_SESSION['error'] == 1))
                    echo '<div id="box-error"><span>Errore durante l\'accesso</span><p>L\'
                    indirizzo e-mail o la password inseriti non sono validi.</p></div>';
            ?>
            <form method="post">
                <div>
                    <h4>Informazioni account</h4>
                    <p><label>Indirizzo e-mail:</label><input type="email" name="email"></p>
                    <p><label>Password:</label><input type="password" name="password"></p><br>
                </div>
                <span><input type="submit" value="Accedi"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
