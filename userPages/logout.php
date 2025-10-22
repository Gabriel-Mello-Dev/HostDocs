<?php
session_start();
session_destroy();
header('Location: ../index.php');
$_SESSION['log']= false;

exit();
