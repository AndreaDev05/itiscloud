<?php
 // pagina php per avviare il download del file

//avvia la sessioen
session_start();

// controlla se l'utente è loggato, altrimenti termina l'esecuzione dello script.
if (!$loggedin) die("</div></body></html>");

// recupera ail path del file da scaricare
$file = $_GET['file'];

//scarica il file
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file");
readfile("DATA/files/$user/$file");



?>