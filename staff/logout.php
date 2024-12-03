<?php
    session_start();
    session_destroy();
    header("Location: ../customers/custmrdshbrd.php"); 
?>
