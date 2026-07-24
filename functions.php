<?php

// **Credenziali di connessione al database:**
require_once 'dbData.php';


// **Connessione al database:**
$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) {
    die("Errore fatale: " . $connection->connect_error); 
}

// **Funzione per creare una tabella (se non esiste già):**
function createTable($name, $query) {
    global $connection; 
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Tabella '$name' creata o già esistente.<br>";
}

// **Funzione per eseguire una query MySQL:**
function queryMysql($query) {
    global $connection; 
    $result = $connection->query($query);
    if (!$result) {
        die("Errore fatale: " . $connection->error);
    }
    return $result;
}

// **Funzione per eliminare una sessione:**
function destroySession() {
    $_SESSION = array(); // Pulisci i dati della sessione
    if (session_id() != "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 2592000, '/'); // Imposta il cookie di sessione per scadere in passato
    }
    session_destroy(); // Elimina la sessione
}

// **Funzione per pulire l'input dell'utente:**
function sanitizeString($var) {
    global $connection; 
    $var = strip_tags($var); 
    $var = htmlentities($var);
    return $connection->real_escape_string($var); 
}

?>

