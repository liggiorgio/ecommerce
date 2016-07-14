<?php
    $pagename = "Carrello";
    include_once("../config.php");
    include_once("../public/header.php");
    include_once("../public/navbar.php");

    // Se l'utente ha già effettuato il login, riporta alla pagina iniziale
    if (!isset($_SESSION['status']) || ($_SESSION['status'] == 0)) {
        header("Location: /login.php");
        exit;
    }
?>
        <div id="wrapper">
            <div id="space-up"></div>
            
            <!--- Page content --->
            <h1>Le mie fatture</h1>
            <p>Clicca su una fattura per visualizzarne i dettagli</p>
            <span class="stretch"></span>
            <?php
                $billsset = mysql_query("SELECT * FROM bills WHERE idUser=".$_SESSION['id']." ORDER BY date DESC");
                if (mysql_num_rows($billsset)>0) {
                    while ($bill = mysql_fetch_array($billsset)) {
                        echo '<div class="bill-detail" onclick="divExpand(this);">';
                            echo "<p class='bill-title'>Fattura del ".$bill['date']." (";
                                if ($bill['amount']==1)
                                    echo $bill['amount']." articolo)</p>";
                                else
                                    echo $bill['amount']." articoli)</p>";
                                echo "<div class='bill-details'><br><hr><br>
                                    <p class='bill-text'>Prodotti acquistati in questa transazione:</p><br>
                                    <p class='bill-descr'>".$bill['descr']."</p><br>
                                    <p class='bill-total'>Totale: ".$bill['total']."€</p>
                                </div>
                            </div>";
                    }
                    echo '<span class="stretch"></span></div>';
                } else {
                    echo '<h3><br>Non sono state trovate fatture legate al tuo account.<br>Effettua prima qualche acquisto!</h3>';
                }
            ?>
            
            <div id="space-down"></div>
        </div>
        <script>
            function divExpand(elem) {
                var h = elem.style.height;
                if (h != 'auto')
                    elem.style.height = "auto";
                else
                    elem.style.height = '18px';
            }
        </script>
        <?php include_once("../public/footer.php"); ?>
    </body>
</html>
