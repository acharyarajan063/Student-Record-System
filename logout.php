<?php

// Start session
session_start();

/*
|--------------------------------------------------------------------------
| Destroy Session
|--------------------------------------------------------------------------
|
| This removes all session data
| and logs the user out.
|
*/

// Remove all session variables
session_unset();

// Destroy session
session_destroy();

/*
|--------------------------------------------------------------------------
| Redirect To Login Page
|--------------------------------------------------------------------------
*/

header("Location: index.php");
exit();

?>