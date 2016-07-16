<?php
    $pagename = "Modifica categoria";
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

    if (!isset($_GET['category']) || empty($_GET['category'])) {
        header("Location: /administration.php");
        exit;
    } else {
        $myId = mysql_real_escape_string($_GET['category']);
        $query = mysql_query("SELECT * FROM categories WHERE id = '$myId'");
        $item = mysql_fetch_array($query);
    }

    $error = 0;

    if ((isset($_POST['name']) && empty($_POST['name'])) ||
        (isset($_POST['description']) && empty($_POST['description']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['name']) && !empty($_POST['name']) &&
       isset($_POST['description']) && !empty($_POST['description'])) {
            $idCat = $_POST['id'];
            $name = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));
            $descr = mysql_real_escape_string(htmlspecialchars(trim($_POST['description'])));
            echo "419";
            $query = "UPDATE categories SET name='$name',descr='$descr' WHERE categories.id='$idCat'";
            $res = mysql_query($query) or ($error = 3);
            if ($error == 0) {
                $_SESSION['success'] = 1;
                header("Location: /administration.php");
                exit;
        } else {
                echo "419";
            $error = 3;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Aggiungi una nuova categoria</h1>
            <?php
                if ($error==1)   // Generico
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==2)   // Campi vuoti
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Devi compilare tutti i campi richiesti.</p></div>';
                if ($error==3)   // E-mail già usata
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
            ?>
            <form method="post">
                <div>
                    <h4>Informazioni categoria</h4>
                    <input type="hidden" name="id" value="<?php echo $myId; ?>">
                    <?php
                        echo '<p><label>Nome:</label><input maxlength="255" type="text" name="name" placeholder="Nome categoria" value="'.$item['name'].'"></p>
                        <p><label>Descrizione:</label><textarea rows="1" cols="26" resize style="margin: 5px 20px;" name="description" placeholder="Descrizione categoria">'.$item['descr'].'</textarea></p>';
                    ?>
                </div>
                <span><input type="submit" value="Modifica categoria"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
