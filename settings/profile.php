<?php
    $pagename = "Modifica profilo";
    include_once("../config.php");
    include_once("../public/header.php");
    include_once("../public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }
    $res = mysql_query("SELECT firstname, lastname, address, email, cities.id AS city FROM users, cities WHERE users.id=".$_SESSION['id']." AND users.city = cities.id");
    $user = mysql_fetch_array($res);

    $error = 0;

    if ((isset($_POST['firstname']) && empty($_POST['firstname'])) ||
        (isset($_POST['lastname']) && empty($_POST['lastname'])) ||
        (isset($_POST['address']) && empty($_POST['address'])) ||
        (isset($_POST['city']) && empty($_POST['city']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['firstname']) && !empty($_POST['firstname']) &&
       isset($_POST['lastname']) && !empty($_POST['lastname']) &&
       isset($_POST['address']) && !empty($_POST['address']) &&
       isset($_POST['city']) && !empty($_POST['city'])) {
            $firstname = mysql_real_escape_string(htmlspecialchars(trim($_POST['firstname'])));
            $lastname = mysql_real_escape_string(htmlspecialchars(trim($_POST['lastname'])));
            $address = mysql_real_escape_string(htmlspecialchars(trim($_POST['address'])));
            $city = mysql_real_escape_string(htmlspecialchars(trim($_POST['city'])));
            $query = "UPDATE users SET firstname='$firstname',lastname='$lastname',address='$address',city='$city' WHERE id=".$_SESSION['id'];
            $res = mysql_query($query) or ($error = 1);
            if ($error == 0) {
                $_SESSION['fullname'] = $firstname." ".$lastname;
                $_SESSION['success'] = 1;
                header("Location: /dashboard.php");
                exit;
        } else {
            $error = 3;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Modifica informazioni personali</h1>
            <?php
                if ($error==1)   // Generico
                    echo '<div id="box-error"><span>Errore durante la modifica</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==2)   // Campi vuoti
                    echo '<div id="box-error"><span>Errore durante la modifica</span><p>Devi compilare tutti i campi richiesti.</p></div>';
            ?>
            <form method="post">
                <div>
                    <?php
                        echo '<h4>Modifica i campi di interesse</h4>
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
                    </select></p><br>
                </div>
                <span><input type="submit" value="Aggiorna"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
