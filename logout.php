<?php

# Start Session:
session_start();

unset($_SESSION['username']); // Delete the username key
session_destroy(); // This would delete all session keys

header('Location: index.php'); // Redirect to login page
?>