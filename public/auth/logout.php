<?php

session_start();

$_SESSION = [];
session_destroy();

header('Location: /public/auth/login.php');
exit();
