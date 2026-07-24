<?php
require_once 'header.php';

// Stampiamo uno script JavaScript per la verifica del nome utente via AJAX.
echo <<<_END
<script>
function checkUser(user)
{
  // Se il campo utente è vuoto, puliamo l'elemento con id 'used' e usciamo dalla funzione.
  if (user.value == '')
  {
    $('#used').html('&nbsp;')
    return
  }

  // Eseguire una richiesta POST per verificare se il nome utente è già in uso.
  $.post(
    'checkuser.php',
    { user : user.value },
    function(data) {
      // Aggiorniamo l'elemento con id 'used' con i dati ricevuti dalla richiesta POST.
      $('#used').html(data)
    }
  )
}
</script>
_END;

// Inizializziamo le variabili per gestire errori, nome utente e password.
$error = $user = $pass = "";

// Se l'utente è già loggato, terminiamo la sessione.
if (isset($_SESSION['user'])) destroySession();

// Se i dati dell'utente sono stati inviati tramite POST, li elaboriamo.
if (isset($_POST['user']))
{
  $user = sanitizeString($_POST['user']);
  $pass = sanitizeString($_POST['pass']);
  $passHash = password_hash($pass, PASSWORD_DEFAULT);

  // Verifichiamo che tutti i campi siano stati compilati.
  if ($user == "" || $pass == "")
  {
    $error = 'Not all fields were entered<br><br>';
  }
  else
  {
    // Controlliamo se il nome utente esiste già nel database.
    $result = queryMysql("SELECT * FROM users WHERE user='$user'");
    if ($result->num_rows)
    {
      $error = 'That username already exists<br><br>';
    }
    else
    {
      // Inseriamo il nuovo utente nel database e terminiamo lo script.
      queryMysql("INSERT INTO users (user, pass) VALUES ('$user', '$passHash')");
      header("Location: index.php");
      die('<h4>Account created</h4>Please log in.</div></body></html>');
    }
  }
}

// Stampiamo il form di registrazione.
echo <<<_END
<form method='post' action='signup.php'>$error
<div data-role='fieldcontain'>
<label></label>
Please enter your details to sign up
</div>
<div data-role='fieldcontain'>
<label>Username</label>
<input type='text' maxlength='16' name='user' value='$user' onBlur='checkUser(this)'>
<label></label><div id='used'>&nbsp;</div>
</div>
<div data-role='fieldcontain'>
<label>Password</label>
<input type='password' maxlength='16' name='pass' value='$pass'>
</div>
<div data-role='fieldcontain'>
<label></label>
<input data-transition='slide' type='submit' value='Sign Up'>
</div>
</div>
</body>
</html>
_END;
?>