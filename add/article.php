<?php
    $pagename = "Aggiungi articolo";
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

    if ((isset($_POST['name']) && empty($_POST['name'])) ||
        (isset($_POST['description']) && empty($_POST['description'])) ||
        (isset($_POST['price']) && empty($_POST['price'])) ||
        (isset($_POST['category']) && empty($_POST['category'])) ||
        (isset($_POST['amount']) && empty($_POST['amount'])) ||
        (isset($_FILES['fileToUpload']['name']) && empty($_FILES['fileToUpload']['name']))) {
        $error = 2;
    }

    // Verifica che tutti i campi siano stati riempiti
    if(isset($_POST['name']) && !empty($_POST['name']) &&
       isset($_POST['description']) && !empty($_POST['description']) &&
       isset($_POST['price']) && !empty($_POST['price']) &&
       isset($_POST['category']) && !empty($_POST['category']) &&
       isset($_POST['amount']) && !empty($_POST['amount']) &&
       isset($_FILES['fileToUpload']['name']) && !empty($_FILES['fileToUpload']['name'])) {
            $name = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));
            $descr = mysql_real_escape_string(htmlspecialchars(trim($_POST['description'])));
            $price = mysql_real_escape_string(htmlspecialchars(trim($_POST['price'])));
            $cat = mysql_real_escape_string($_POST['category']);
            $amount = mysql_real_escape_string(htmlspecialchars(trim($_POST['amount'])));
            $query = "INSERT INTO articles(name,descr,price,cat,amount) VALUES('$name','$descr','$price','$cat','$amount')";
            $res = mysql_query($query) or ($error = 3);
            /*
            $target_dir = "/public/res/articles/";
            $target_file = $target_dir.$id['id'].".jpg";
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($imageFileType != "jpg") {
                $error = 4;
            }
            if (!move_uploaded_file($_FILES["thumb"]["name"], $target_file)) {
                $error = 4;
            }*/
            {
                // Here we save the thumbnail of the article
                $query = "SELECT id FROM articles ORDER BY id DESC LIMIT 1";
                $id = mysql_fetch_assoc(mysql_query($query));
                $target_dir = "../public/res/articles/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $target_file = $target_dir.strval($id['id']).".jpg";
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "jpeg") {
                    echo "Sorry, only JPG files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    $error = 4;
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        $error = 4;
                    }
                }
            }
            if ($error == 0) {
                $_SESSION['success'] = 1;
                header("Location: /administration.php");
                exit;
        } else {
                echo "<br>".$_FILES["fileToUpload"]["tmp_name"];
            //$error = 3;
        }
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Aggiungi un nuovo articolo</h1>
            <?php
                if ($error==1)   // Generico
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==2)   // Campi vuoti
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Devi compilare tutti i campi richiesti.</p></div>';
                if ($error==3)   // E-mail già usata
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Non è stato possibile
                    completare l\'operazione, riprova più tardi.</p></div>';
                if ($error==4)   // Formato immagine errato
                    echo '<div id="box-error"><span>Errore durante l\'operazione</span><p>Errore durante il caricamento del file. Il formato è errato o si è verificato un problema con il file.</p></div>';
            ?>
            <form method="post" enctype="multipart/form-data">
                <div>
                    <h4>Informazioni articolo</h4>
                    <p><label>Nome:</label><input maxlength="255" type="text" name="name" placeholder="Nome articolo"></p>
                    <p><label>Descrizione:</label><textarea rows="1" cols="26" resize style="margin: 5px 20px;" name="description" placeholder="Descrizione articolo"></textarea></p>
                    <p><label>Prezzo:</label><input type="number" step="0.01" name="price" placeholder="Prezzo"></p>
                    <p><label>Categoria:</label><select name="category">
                        <option value="">Seleziona una categoria... </option>
                    <?php
                        $catset = mysql_query("SELECT id,name FROM categories ORDER BY name");
                        while ($cats = mysql_fetch_array($catset)) {
                            echo "<option value=\"".$cats['id']."\">".$cats['name']."</option>";
                        }
                    ?>
                        </select></p>
                    <p><label>Quantità:</label><input type="number" name="amount" placeholder="Quantità"></p>
                    <p><label>Immagine (.jpg):</label><input type="file" name="fileToUpload"></p>
                </div>
                <span><input type="submit" value="Aggiungi articolo"></span>
            </form>
            
            <div id="space-down"></div>
        </div>
    <?php include_once("../public/footer.php"); ?>
    </body>
</html>
