<?php
session_start();
unset($_SESSION['logged_id']);
header('Location: index.php');

