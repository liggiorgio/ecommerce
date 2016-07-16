<?php
    $pagename = "Modifica utente";
    include_once("../config.php");
    include_once("../public/header.php");
    include_once("../public/navbar.php");

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

    if (!isset($_GET['user']) || empty($_GET['user'])) {
        header("Location: /administration.php");
        exit;
    } else {
        $myId = mysql_real_escape_string($_GET['user']);
        $query = mysql_query("SELECT users.id AS id, firstname, lastname, address, email, cities.id AS city FROM users, cities WHERE users.id=".$myId." AND users.city = cities.id");
        $user = mysql_fetch_array($query);
    }

    $error = 0;

    // Bad request
    if ((isset($_POST['firstname']) && empty($_POST['firstname'])) ||
        (isset($_POST['lastname']) && empty($_POST['lastname'])) ||
        (isset($_POST['address']) && empty($_POST['address'])) ||
        (isset($_POST['city']) && empty($_POST['city'])) ||
        (isset($_POST['email']) && empty($_POST['email']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['firstname']) && !empty($_POST['firstname']) &&
       isset($_POST['lastname']) && !empty($_POST['lastname']) &&
       isset($_POST['address']) && !empty($_POST['address']) &&
       isset($_POST['city']) && !empty($_POST['city']) &&
       isset($_POST['password1']) && !empty($_POST['password1']) &&
       isset($_POST['password2']) && !empty($_POST['password2'])) {
            $firstname = mysql_real_escape_string(htmlspecialchars(trim($_POST['firstname'])));
            $lastname = mysql_real_escape_string(htmlspecialchars(trim($_POST['lastname'])));
            $address = mysql_real_escape_string(htmlspecialchars(trim($_POST['address'])));
            $email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
            $password1 = mysql_real_escape_string(md5(htmlspecialchars(trim($_POST['password1'])).$salt));
            $password2 = mysql_real_escape_string(md5(htmlspecialchars(trim($_POST['password2'])).$salt));
            $city = $_POST['city'];
            if ($password1 != $password2) {
                $error = 3;
            } else {
                $query = "UPDATE users SET firstname='$firstname',lastname='$lastname',address='$address',email='$email',city='$city',password='$password1' WHERE id=".$myId;
                $res = mysql_query($query) or ($error = 1);
                if ($error == 0) {
                    $_SESSION['success'] = 1;
                    header("Location: /administration.php");
                    exit;
            } else {
                $error = 3;
            }
        }
    } elseif (isset($_POST['firstname']) && !empty($_POST['firstname']) &&
       isset($_POST['lastname']) && !empty($_POST['lastname']) &&
       isset($_POST['address']) && !empty($_POST['address']) &&
       isset($_POST['city']) && !empty($_POST['city']) &&
       isset($_POST['password1']) && empty($_POST['password1']) &&
       isset($_POST['password2']) && empty($_POST['password2'])) {
            $firstname = mysql_real_escape_string(htmlspecialchars(trim($_POST['firstname'])));
            $lastname = mysql_real_escape_string(htmlspecialchars(trim($_POST['lastname'])));
            $address = mysql_real_escape_string(htmlspecialchars(trim($_POST['address'])));
            $email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
            $city = $_POST['city'];
            $query = "UPDATE users SET firstname='$firstname',lastname='$lastname',address='$address',email='$email',city='$city' WHERE id=".$myId;
            $res = mysql_query($query) or ($error = 1);
            if ($error == 0) {
                $_SESSION['success'] = 1;
                header("Location: /administration.php");
                exit;
        } else {
            $error = 3;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Modifica informazioni utente</h1>
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
                        echo '<h4>Informazioni del profilo</h4>
                        <input type="hidden" name="id" value="'.$user['id'].'">
                        <p><label>Nome:</label><input type="text" name="firstname" placeholder="Il tuo nome" value="'.$user['firstname'].'"></p>
                        <p><label>Cognome:</label><input type="text" name="lastname" placeholder="Il tuo cognome" value="'.$user['lastname'].'"></p>
                        <p><label>Indirizzo:</label><input type="text" name="address" placeholder="Indirizzo e numero civico" value="'.$user['address'].'"></p>
                        <p><label>Città:</label><select name="city">
                            <option>Seleziona una città...</option>';
                            $cityset = mysql_query("SELECT * FROM cities ORDER BY name");
                            while ($cities = mysql_fetch_array($cityset)) {
                                if ($cities['id'] == $user['city'])
                                    echo "<option selected value=\"".$cities['id']."\">".$cities['name']."</option>";
                                else
                                    echo "<option value=\"".$cities['id']."\">".$cities['name']."</option>";
                            }
                    ?>
                    </select></p>
                    <?php
                        echo '<h4>Informazioni dell\'account</h4>
                        <p><label>Indirizzo e-mail:</label><input type="email" name="email" placeholder="indirizzo@esempio.it" value="'.$user['email'].'"></p>
                        <p><label>Nuova password:</label><input type="password" name="password1" placeholder="Nuova password"></p>
                        <p><label>Conferma password:</label><input type="password" name="password2" placeholder="Conferma password"></p><br>';
                    ?>
                    <br>
                </div>
                <span><input type="submit" value="Aggiorna informazioni"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
