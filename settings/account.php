<?php
    $pagename = "Modifica account";
    include_once("../config.php");
    include_once("../public/header.php");
    include_once("../public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }
    $res = mysql_query("SELECT email FROM users WHERE users.id=".$_SESSION['id']);
    $user = mysql_fetch_array($res);

    $error = 0;

    if ((isset($_POST['email']) && empty($_POST['email']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['email']) && !empty($_POST['email']) &&
       isset($_POST['password1']) && !empty($_POST['password1']) &&
       isset($_POST['password2']) && !empty($_POST['password2'])) {
            $email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
            $password1 = mysql_real_escape_string(md5(htmlspecialchars(trim($_POST['password1'])).$salt));
            $password2 = mysql_real_escape_string(md5(htmlspecialchars(trim($_POST['password2'])).$salt));
            if ($password1 != $password2) {
                $error = 3;
            } else {
                $query = "UPDATE users SET email='$email',password='$password1' WHERE id=".$_SESSION['id'];
                $res = mysql_query($query) or ($error = 1);
                if ($error == 0) {
                    $_SESSION['success'] = 1;
                    header("Location: /dashboard.php");
                    exit;
                } else {
                    $error = 3;
                }
            }
        } elseif ((isset($_POST['email']) && !empty($_POST['email'])) &&
                  (isset($_POST['password1']) && empty($_POST['password1'])) &&
                  (isset($_POST['password2']) && empty($_POST['password2']))) {
            $email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
            $query = "UPDATE users SET email='$email' WHERE id=".$_SESSION['id'];
            $res = mysql_query($query) or ($error = 1);
            if ($error == 0) {
                $_SESSION['success'] = 1;
                header("Location: /dashboard.php");
                exit;
            }
        }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Modifica informazioni account</h1>
            <?php
                if ($error==1)   // Generico
                    echo '<div id="box-error"><span>Errore durante la modifica</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==2)   // Campi vuoti
                    echo '<div id="box-error"><span>Errore durante la modifica</span><p>Devi compilare tutti i campi richiesti.</p></div>';
                if ($error==3)   // Password errata
                    echo '<div id="box-error"><span>Errore durante la modifica</span><p>Le password non coincidono.</p></div>';
            ?>
            <form method="post">
                <div>
                    <?php
                        echo '<h4>Modifica i campi di interesse</h4>
                        <p><label>Indirizzo e-mail:</label><input type="email" name="email" placeholder="indirizzo@esempio.it" value="'.$user['email'].'"></p>
                        <p><label>Nuova password:</label><input type="password" name="password1" placeholder="Nuova password"></p>
                        <p><label>Conferma password:</label><input type="password" name="password2" placeholder="Conferma password"></p><br>';
                    ?>
                    </select></p><br>
                </div>
                <span><input type="submit" value="Aggiorna"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
