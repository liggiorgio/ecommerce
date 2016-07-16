<?php
    $pagename = "Modifica articolo";
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

    $error = 0;

    if (!isset($_GET['article']) || empty($_GET['article'])) {
        header("Location: /administration.php");
        exit;
    } else {
        $myId = mysql_escape_string($_GET['article']);
        $query = mysql_query("SELECT * FROM articles WHERE id = '$myId'");
        $item = mysql_fetch_array($query);
    }

    if ((isset($_POST['id']) && empty($_POST['id'])) ||
        (isset($_POST['name']) && empty($_POST['name'])) ||
        (isset($_POST['description']) && empty($_POST['description'])) ||
        (isset($_POST['price']) && empty($_POST['price'])) ||
        (isset($_POST['category']) && empty($_POST['category'])) ||
        (isset($_POST['amount']) && empty($_POST['amount']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['id']) && !empty($_POST['id']) &&
       isset($_POST['name']) && !empty($_POST['name']) &&
       isset($_POST['description']) && !empty($_POST['description']) &&
       isset($_POST['price']) && !empty($_POST['price']) &&
       isset($_POST['category']) && !empty($_POST['category']) &&
       isset($_POST['amount']) && !empty($_POST['amount'])) {
            $idArt = $_POST['id'];
            $name = mysql_escape_string(htmlspecialchars(trim($_POST['name'])));
            $descr = mysql_escape_string(htmlspecialchars(trim($_POST['description'])));
            $price = mysql_escape_string(htmlspecialchars(trim($_POST['price'])));
            $cat = mysql_escape_string($_POST['category']);
            $amount = mysql_escape_string(htmlspecialchars(trim($_POST['amount'])));
            $query = "UPDATE articles SET name='$name',descr='$descr',price='$price',cat='$cat',amount='$amount' WHERE id='$idArt'";
            $res = mysql_query($query) or ($error = 3);
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
            <h1>Modifica un articolo esistente</h1>
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
                    <h4>Informazioni articolo</h4>
                    <input type="hidden" name="id" value="<?php echo $myId; ?>">
                    <?php
                        echo '<p><label>Nome:</label><input maxlength="255" type=text name="name" placeholder="Nome articolo" value="'.($item['name']).'"></p>
                        <p><label>Descrizione:</label><textarea rows="1" cols="26" resize="resize" style="margin: 5px 20px;" name="description" placeholder="Descrizione articolo">'.$item['descr'].'</textarea></p>
                        <p><label>Prezzo:</label><input type="number" step="0.01" name="price" placeholder="Prezzo" value="'.$item['price'].'"></p>
                        <p><label>Categoria:</label><select name="category">
                            <option value="">Seleziona una categoria... </option>';

                            $catset = mysql_query("SELECT id,name FROM categories ORDER BY name");
                            while ($cats = mysql_fetch_array($catset)) {
                                if ($cats['id'] == $item['cat'])
                                        echo "<option selected value=\"".$cats['id']."\">".$cats['name']."</option>";
                                    else
                                        echo "<option value=\"".$cats['id']."\">".$cats['name']."</option>";
                            }

                            echo '</select></p>
                        <p><label>Quantità:</label><input type="number" name="amount" placeholder="Quantità" value="'.$item['amount'].'"></p>';
                    ?>
                </div>
                <span><input type="submit" value="Aggiorna articolo"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
