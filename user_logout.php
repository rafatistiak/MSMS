<?php
session_start();
// Unset only the customer-related session variables so it doesn't affect an admin session if you are testing both
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
// Redirect back to the homepage
header("Location: index.php");
exit();
?>