<?php
require_once 'header.php';

// Inizializzazione delle variabili per gestire errori, nome utente e password
$error = $user = $pass = "";

// Controlla se l'utente ha inviato il form di login
if (isset($_POST['user']))
{
    // Sanitizza le stringhe di input per evitare vulnerabilità
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
    {
        $error = 'Not all fields were entered';
    }
    else
    {
        // Esegue una query per verificare le credenziali dell'utente
        $result = queryMySQL("SELECT pass FROM users WHERE user='$user' LIMIT 1");
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if(password_verify($pass, $row['pass']))
        {
            // Imposta le variabili di sessione e reindirizza l'utente alla pagina dei membri
            $_SESSION['user'] = $user;
            header("Location: index.php");
            die("logged in </body></html>");
        }
        else
        {
            $error = "Invalid login attempt";
        }
    }
}

// Mostra il form di login
echo <<<_END
<form method='post' action='login.php'>
<div data-role='fieldcontain'>
<label></label>
<span class='error'>$error</span>
</div>
<div data-role='fieldcontain'>
<label></label>
Please enter your details to log in
</div>
<div data-role='fieldcontain'>
<label>Username</label>
<input type='text' maxlength='16' name='user' value='$user'>
</div>
<div data-role='fieldcontain'>
<label>Password</label>
<input type='password' maxlength='16' name='pass' value='$pass'>
</div>
<div data-role='fieldcontain'>
<label></label>
<input data-transition='slide' type='submit' value='Login'>
</div>
</form>
</div>
</body>
</html>
_END;
?>