<?php
    $pagename = "Amministrazione";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /index.php");
        exit;
    }

    // Se l'utente non è un amministratore, riporta alla pagina iniziale
    if (!isset($_SESSION['admin']) || ($_SESSION['admin'] == 0)) {
        header("Location: /index.php");
        exit;
    }

    if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
        $message = 1;
        $_SESSION['success'] = 0;
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Amministrazione del sito</h1>
            <p>Aggiungi, modifica, o rimuovi una delle seguenti risorse dal sito.</p><br>
            <div id="admin-section">
                <p class="artcat-detail">Gestione articoli</p>
                    <form action="/add/article.php">
                        <fieldset>
                            <legend>Aggiungi articolo</legend>
                            <label>Aggiungi articolo: </label>
                            <input type="submit" value="Aggiungi">
                        </fieldset>
                    </form>
                
                    <form action="/edit/article.php" method="get">
                        <fieldset>
                            <legend>Modifica articolo</legend>
                            <label>Modifica l'articolo: </label>
                            <select name="article">
                                <option value="">Seleziona un articolo... </option>
                                <?php
                                    $artset = mysql_query("SELECT * FROM articles ORDER BY name");
                                    while ($arts = mysql_fetch_array($artset)) {
                                        echo "<option value=\"".$arts['id']."\">".substr($arts['name'],0,50)."...</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Modifica">
                        </fieldset>
                    </form>
                
                    <form action="/delete/article.php" method="post">
                        <fieldset>
                            <legend>Rimuovi articolo</legend>
                            <label>Rimuovi l'articolo: </label>
                            <select name="article">
                                <option value="">Seleziona un articolo... </option>
                                <?php
                                    $artset = mysql_query("SELECT * FROM articles ORDER BY name");
                                    while ($arts = mysql_fetch_array($artset)) {
                                        echo "<option value=\"".$arts['id']."\">".substr($arts['name'],0,50)."...</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Rimuovi">
                        </fieldset>
                    </form><br>
                
                <p class="artcat-detail">Gestione categorie</p>
                    <form action="/add/category.php">
                        <fieldset>
                            <legend>Aggiungi categoria</legend>
                            <label>Aggiungi categoria: </label>
                            <input type="submit" value="Aggiungi">
                        </fieldset>
                    </form>
                
                    <form action="/edit/category.php" method="get">
                        <fieldset>
                            <legend>Modifica categoria</legend>
                            <label>Modifica la categoria: </label>
                            <select name="category">
                                <option value="">Seleziona una categoria... </option>
                                <?php
                                    $catset = mysql_query("SELECT * FROM categories ORDER BY name");
                                    while ($cats = mysql_fetch_array($catset)) {
                                        echo "<option value=\"".$cats['id']."\">".substr($cats['name'],0,50)."...</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Modifica">
                        </fieldset>
                    </form>
                
                    <form action="/delete/category.php" method="post">
                        <fieldset>
                            <legend>Rimuovi categoria</legend>
                            <label>Rimuovi la categoria: </label>
                            <select name="category">
                                <option value="">Seleziona una categoria... </option>
                                <?php
                                    $catset = mysql_query("SELECT * FROM categories ORDER BY name");
                                    while ($cats = mysql_fetch_array($catset)) {
                                        echo "<option value=\"".$cats['id']."\">".substr($cats['name'],0,50)."...</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Rimuovi">
                        </fieldset>
                    </form><br>
                
                <p class="artcat-detail">Gestione città</p>
                    <form action="/add/city.php" method="post">
                        <fieldset>
                            <legend>Aggiungi città</legend>
                            <label>Aggiungi città:</label>
                            <input type="text" name="city" placeholder="Nome città">
                            <input type="submit" value="Aggiungi">
                        </fieldset>
                    </form>

                    <form action="/edit/city.php" method="post">
                        <fieldset>
                            <legend>Modifica città</legend>
                            <label>Modifica la città: </label>
                            <select name="city">
                                <option value="">Seleziona una città... </option>
                                <?php
                                    $cityset = mysql_query("SELECT * FROM cities ORDER BY name");
                                    while ($cities = mysql_fetch_array($cityset)) {
                                        echo "<option value=\"".$cities['id']."\">".$cities['name']."</option>";
                                    }
                                ?>
                            </select>
                            <label> in </label>
                            <input type="text" name="newname" placeholder="Nuovo nome">
                            <input type="submit" value="Modifica">
                        </fieldset>
                    </form>

                    <form action="/delete/city.php" method="post">
                        <fieldset>
                            <legend>Rimuovi città</legend>
                            <label>Rimuovi la città: </label>
                            <select name="city">
                                <option value="">Seleziona una città... </option>
                                <?php
                                    $cityset = mysql_query("SELECT * FROM cities ORDER BY name");
                                    while ($cities = mysql_fetch_array($cityset)) {
                                        echo "<option value=\"".$cities['id']."\">".$cities['name']."</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Rimuovi">
                        </fieldset>
                    </form><br>
                
                <p class="artcat-detail">Gestione utenti</p>
                    <form action="/edit/user.php" method="get">
                        <fieldset>
                            <legend>Modifica utente</legend>
                            <label>Modifica l'utente: </label>
                            <select name="user">
                                <option value="">Seleziona un utente... </option>
                                <?php
                                    $userset = mysql_query("SELECT id,firstname,lastname FROM users ORDER BY firstname");
                                    while ($users = mysql_fetch_array($userset)) {
                                        if ($users['id'] != $_SESSION['id'])
                                            echo "<option value=\"".$users['id']."\">".$users['firstname']." ".$users['lastname']."</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Modifica">
                        </fieldset>
                    </form>
                
                    <form action="/delete/user.php" method="post">
                        <fieldset>
                            <legend>Rimuovi utente</legend>
                            <label>Rimuovi l'utente: </label>
                            <select name="user">
                                <option value="">Seleziona un utente... </option>
                                <?php
                                    $userset = mysql_query("SELECT id,firstname,lastname FROM users ORDER BY firstname");
                                    while ($users = mysql_fetch_array($userset)) {
                                        if ($users['id'] != $_SESSION['id'])
                                            echo "<option value=\"".$users['id']."\">".$users['firstname']." ".$users['lastname']."</option>";
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Rimuovi">
                        </fieldset>
                    </form>
            </div>
            <div id="space-down"></div>
        </div>
        <?php
            if (isset($message) && ($message == 1))
                echo "<script type='text/javascript'>alert('Operazione completata correttamente.');</script>";
    include_once("./public/footer.php"); ?>
    </body>
</html>
