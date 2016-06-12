<?php
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");
/*
    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
        header("Location: index.php");
        EXIT;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['name']) && ($_POST['name'] != "") &&
       isset($_POST['surname']) && ($_POST['surname'] != "") &&
       isset($_POST['address']) && ($_POST['address'] != "") &&
       isset($_POST['city']) && ($_POST['city'] != "") &&
       isset($_POST['email']) && ($_POST['email'] != "") &&
       isset($_POST['password']) && ($_POST['password'] != "")) {
           $name = mysql_escape_string(htmlspecialchars(trim($_POST['name'])));
           $surname = mysql_escape_string(htmlspecialchars(trim($_POST['surname'])));
           $email = mysql_escape_string(htmlspecialchars(trim($_POST['email'])));
           $password = md5(mysql_escape_string(htmlspecialchars(trim($_POST['password']))).$SALT);
           $address = mysql_escape_string(htmlspecialchars(trim($_POST['address'])));
           $city = mysql_escape_string($_POST['city']);
    }

*/
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Registrazione</h1>
            <?php
                if (true)   // Condizione migliorabile
                    echo '<div id="box-error"><span>Errore durante la registrazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if (true)   // Condizione migliorabile
                    echo '<div id="box-error"><span>Errore durante la registrazione</span><p>Devi compilare tutti i campi di testo.</p></div>';
            ?>
            <form method="post">
                <div>
                    <h4>Informazioni personali</h4>
                    <p><label>Nome:</label><input type="text" name="firstname"></p>
                    <p><label>Cognome:</label><input type="text" name="lastname"></p>
                    <p><label>Indirizzo:</label><input type="text" name="address"></p>
                    <p><label>Città:</label><input type="text" name="city"></p><br>
                    <h4>Informazioni account</h4>
                    <p><label>Indirizzo e-mail:</label><input type="text" name="email"></p>
                    <p><label>Password:</label><input type="password" name="password"></p><br>
                </div>
                <span><input type="submit" value="Registrati"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
