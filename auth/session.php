<?php
session_start();

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ../auth/login.php");
    exit();
}