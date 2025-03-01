<?php
session_start();
if (!isset($_SESSION['Usuario_DNI_U'])) { 
    header("Location: login.php");
}
?>