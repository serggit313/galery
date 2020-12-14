<?php
session_start();
session_unset();
setcookie('user','ok', time()-3600, '/');
session_destroy();
header('Location: index.php');
?>