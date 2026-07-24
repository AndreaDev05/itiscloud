<?php

session_start();

// Inizializza il layout base della pagina HTML con inclusione di metadati, CSS e JavaScript
echo <<<_INIT
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
<link rel='stylesheet' href='styles.css'>
<script src='javascript.js'></script>
<script src='jquery-2.2.4.min.js'></script>
<script src='jquery.mobile-1.4.5.min.js'></script>
_INIT;

require_once 'functions.php';


$userstr = 'Welcome Guest';
if (isset($_SESSION['user']))
{
    // Recupera il nome utente dalla sessione e aggiorna lo stato di login e la stringa di benvenuto
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
}
else $loggedin = FALSE; // Imposta lo stato di login su FALSE se l'utente non è loggato

// Stampa il titolo della pagina e l'header utilizzando le variabili definite sopra
echo <<<_MAIN
<title>Robin's Nest: $userstr</title>
</head>
<body>
<div data-role='page'>
<div data-role='header'>
<div id='logo' class='center'>R<img id='robin' src='robin.gif'>bin's Nest</div>
<div class='username'>$userstr</div>
</div>
<div data-role='content'>
_MAIN;

// Se l'utente è loggato, mostra i link per navigare all'interno dell'app
if ($loggedin)
{
    echo <<<_LOGGEDIN
<div class='center'>
<a data-role='button' data-inline='true' data-icon='home'
data-transition="slide" href='members.php?view=$user'>Home</a>
<a data-role='button' data-inline='true'
data-transition="slide" href='file.php'>File</a>
<a data-role='button' data-inline='true'
data-transition="slide" href='film&media.php'>Film & Media</a>
<a data-role='button' data-inline='true'
data-transition="slide" href='music.php'>Music</a>
<a data-role='button' data-inline='true'
data-transition="slide" href='foto.php'>Foto</a>
<a data-role='button' data-inline='true'
data-transition="slide" href='logout.php'>Log out</a>
</div>
_LOGGEDIN;
}
else // Se non è loggato, mostra i link per il login o la registrazione
{
    echo <<<_GUEST
<div class='center'>
<a data-role='button' data-inline='true' data-icon='home'
data-transition='slide' href='index.php'>Home</a>
<a data-role='button' data-inline='true' data-icon='plus'
data-transition="slide" href='signup.php'>Sign Up</a>
<a data-role='button' data-inline='true' data-icon='check'
data-transition="slide" href='login.php'>Log In</a>
</div>
<p class='info'>(You must be logged in to use this app)</p>
_GUEST;
}
?>