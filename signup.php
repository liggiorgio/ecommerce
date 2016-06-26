<?php
    $pagename = "Registrazione";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if ((isset($_SESSION['status'])) && ($_SESSION['status'] == 1)) {
        header("Location: index.php");
        exit;
    }

    $error = 0;

    if ((isset($_POST['firstname']) && empty($_POST['firstname'])) ||
        (isset($_POST['lastname']) && empty($_POST['lastname'])) ||
        (isset($_POST['address']) && empty($_POST['address'])) ||
        (isset($_POST['city']) && empty($_POST['city'])) ||
        (isset($_POST['email']) && empty($_POST['email'])) ||
        (isset($_POST['password']) && empty($_POST['password']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['firstname']) && !empty($_POST['firstname']) &&
       isset($_POST['lastname']) && !empty($_POST['lastname']) &&
       isset($_POST['address']) && !empty($_POST['address']) &&
       isset($_POST['city']) && !empty($_POST['city']) &&
       isset($_POST['email']) && !empty($_POST['email']) &&
       isset($_POST['password']) && !empty($_POST['password'])) {
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname = htmlspecialchars(trim($_POST['lastname']));
            $address = htmlspecialchars(trim($_POST['address']));
            $city = $_POST['city'];
            $email = htmlspecialchars(trim($_POST['email']));
            $password = md5(htmlspecialchars(trim($_POST['password'])).$salt);
            $query = "INSERT INTO users(firstname,lastname,email,password,address,city) VALUES('$firstname','$lastname','$email','$password','$address','$city')";
            $res = mysql_query($query) or ($error = 3);
            if ($error == 0) {
                $_SESSION['status'] = 0;
                $_SESSION['success'] = 1;
                header("Location: login.php");
                exit;
        } else {
            $error = 3;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Registrazione</h1>
            <?php
                if ($error==1)   // Generico
                    echo '<div id="box-error"><span>Errore durante la registrazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==2)   // Campi vuoti
                    echo '<div id="box-error"><span>Errore durante la registrazione</span><p>Devi compilare tutti i campi richiesti.</p></div>';
                if ($error==3)   // E-mail già usata
                    echo '<div id="box-error"><span>Errore durante la registrazione</span><p>L\'indirizzo e-mail inserito è già utilizzato da un altro account.</p></div>';
            ?>
            <form method="post">
                <div>
                    <h4>Informazioni personali</h4>
                    <p><label>Nome:</label><input type="text" name="firstname" placeholder="Il tuo nome"></p>
                    <p><label>Cognome:</label><input type="text" name="lastname" placeholder="Il tuo cognome"></p>
                    <p><label>Indirizzo:</label><input type="text" name="address" placeholder="Indirizzo e numero civico"></p>
                    <p><label>Città:</label><select name="city">
                        <option value="">Seleziona una città... </option>
                    <?php
                        $cityset = mysql_query("SELECT * FROM cities ORDER BY name");
                        while ($cities = mysql_fetch_array($cityset)) {
                            echo "<option value=\"".$cities['id']."\">".$cities['name']."</option>";
                        }
                    ?>
                        </select></p><br>
                    <h4>Informazioni account</h4>
                    <p><label>Indirizzo e-mail:</label><input type="email" name="email" placeholder="indirizzo@esempio.it"></p>
                    <p><label>Password:</label><input type="password" name="password" placeholder="Password"></p><br>
                </div>
                <span><input type="submit" value="Registrati"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
