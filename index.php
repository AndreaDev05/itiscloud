<?php
	session_start();
	require_once 'header.php';
	
	echo "<div class='center'>Welcome to Robin's Nest,";
	
    // Controlla se l'utente è loggato. 
	if ($loggedin) 
	  echo " $user, you are logged in";
	else
	  // Se l'utente non è loggato, invita a registrarsi o accedere.
	echo ' please sign up or log in';
	
	echo <<<_END
		</div><br>
		</div>
		<div data-role="footer">
		<h4>Web App</h4>
		</div>
		</body>
		</html>
		_END;
?>