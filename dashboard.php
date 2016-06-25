<?php
    $pagename = "Dashboard";
    include_once("./config.php");
    include_once("./public/header.php");
    include_once("./public/navbar.php");

    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: login.php");
        exit;
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Dashboard</h1>
            <p>Visualizza e modifica il tuo profilo personale, e visualizza le tue attività recenti.</p>
            <?php
                $res = mysql_query("SELECT firstname, lastname, address, email, cities.name AS city FROM users, cities WHERE users.id=".$_SESSION['id']." AND users.city = cities.id");
                $user = mysql_fetch_array($res);
                echo '<span class="stretch"></span>
                    <div id="account-info">
                        <div class="user-info-table">
                            <p class="artcat-detail">Informazioni personali</p>
                            <div class="user-text">
                                <p><b>Nome: </b>'.$user['firstname'].'</p>
                                <p><b>Cognome: </b>'.$user['lastname'].'</p>
                                <p><b>Indirizzo: </b>'.$user['address'].'</p>
                                <p><b>Città: </b>'.$user['city'].'</p>
                            </div>
                            <button title="Modifica informazioni personali">Modifica</button>
                        </div>
                        <span class="stretch"></span>
                        <span class="stretch"></span>
                        <div class="user-info-table">
                            <p class="artcat-detail">Informazioni account</p>
                            <div class="user-text">
                                <p><b>Indirizzo e-mail</b><br>'.$user['email'].'</p>
                                <p><b>Password</b><br>**********</p>
                            </div>
                            <button title="Modifica informazioni account">Modifica</button>
                        </div>
                        <span class="stretch"></span>
                        <span class="stretch"></span>
                        <div class="user-info-table">
                            <p class="artcat-detail">Fatture</p>
                            <div class="user-text">
                                <p>Visualizza <u>qui</u> le tue fatture.</p>
                            </div>
                        </div>
                    </div><span class="stretch"></span>';
            ?>
            <div id="space-down"></div>
        </div>
    <?php include_once("./public/footer.php"); ?>
    </body>
</html>
