<?php
session_start();
setcookie('email','', time() - 60 * 60 * 24 * 7);
setcookie('name','', time() - 60 * 60 * 24 * 7);
setcookie('type','', time() - 60 * 60 * 24 * 7);
$_SESSION = array();
session_destroy();
header("Location: index.php")
?>
