<?php
session_start();
session_destroy();
header('Location:indexp.php');
exit();

?>