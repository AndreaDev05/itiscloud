<?php
require_once 'header.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controlla se l'utente è loggato, altrimenti termina l'esecuzione dello script.
if (!$loggedin) die("</div></body></html>");

// Inizializza la variabile $file con un valore predefinito se non è definita nella richiesta GET
$file = isset($_GET['file']) ? $_GET['file'] : 'default_value';

// Inizializza la variabile $view con un valore predefinito se non è definita nella richiesta GET
$view = isset($_GET['view']) ? $_GET['view'] : 'default_value';

// Aggiunta di un nuovo file 
if (isset($_POST['file'])) {
    // Controlla se il file è stato caricato correttamente
    if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
        // Recupera il percorso temporaneo del file caricato
        $tmp_file = $_FILES['file']['tmp_name'];
        // Recupera il nome del file
        $filename = $_FILES['file']['name'];

        // Salva il file nel server nella cartella apposita /DATA/files/$user
        $data_path = "DATA/files/";
        $user_path = $data_path . $user . "/";
        // Assicurati che la cartella dell'utente esista, altrimenti creala
        if (!file_exists($user_path)) {
            mkdir($user_path, 0777, true); // Crea la cartella ricorsivamente con i permessi 0777
        }
        // Sposta il file dal percorso temporaneo alla cartella dell'utente
        move_uploaded_file($tmp_file, $user_path . "/" . $filename);

        // Salva le informazioni sul file nel database
        $file_path = $user . "/" . $filename;
        $filetype = $_FILES['file']['type'];
        $filesize = $_FILES['file']['size'];
        $query = "INSERT INTO files (filename, pathfile, filetype, filesize) VALUES ('$filename', '$file_path', '$filetype', '$filesize')";
        queryMysql($query);
    } else {
        // Il file non è stato caricato correttamente
        echo "Errore: Nessun file caricato.";
    }
}

// Form per l'inserimento di un nuovo file.
echo <<< _END
<form method="post" action="file.php?view=$file" enctype="multipart/form-data">
    <input type="file" id="file" name="file" multiple>
    <input type="submit" value="Carica">
</form>
<br>
_END;

    // Gestisce l'eliminazione di un file.
    if (isset($_GET['erase']))
    {
        $erase = sanitizeString($_GET['erase']);

        //recupero il path del file da eliminare dal database
        $query = "SELECT pathfile FROM files WHERE filename='$erase'";
        $result = queryMysql($query);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $pathfile = $row['pathfile'];

        // Elimina definitivamente il file dal server dalla cartella apposita /DATA/files/$user
        delete_file("DATA/files/".$pathfile);

        // elimina le informazioni sul file dal database
        $query = "DELETE FROM files WHERE filename='$erase'";
        queryMysql($query);
        
    }

    // Recupera e mostra tutti i file per l'utente corrente.
    $pathuser = "DATA/files/$user/";
    // query per recuperare tutti i file dell'utente corrente 
    $query = "SELECT * FROM files WHERE pathfile LIKE '$pathuser%'";
    $result = queryMysql($query);
    $num = $result->num_rows;
    for ($j = 0; $j < $num; ++$j)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);


        // mostra il nome del file e le varie informazioni sul file
        echo $row['filename'];
        echo "Type: ". $row['filetype'];
        echo "Size: ". $row['filesize'];

            // mostra il link per scaricare il file
            echo "<a href='download.php?file=". $row['pathfile']. "'>". $row['filename']. "</a>";

            //  mostra il link per cancellare il file
            echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>erase</a>]";
            echo "<br>";
}



// Se non ci sono file, mostra un messaggio informativo.
if (!$num) 
{
    echo "<br><span class='info'>No file yet</span><br><br>";
}

// Fornisce un link per aggiornare i messaggi.
echo "<br><a data-role='button' href='messages.php?view=$view'>Refresh messages</a>";
?>

</div><br>
</body>
</html>
