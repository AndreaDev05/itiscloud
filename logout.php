<?php
require_once 'header.php'; 

// se l'utente è loggato, lo disconnette
if (isset($_SESSION['user']))
{
	destroySession();
	header("Location: index.php");
	die("<br><div class='center'>You have been logged out. Please
	<a data-transition='slide' href='index.php'>click here</a>
	to refresh the screen.</div>");
}
else die("<div class='center'>You cannot log out because you are not logged in</div>");

?>
</div>
</body>
</html>