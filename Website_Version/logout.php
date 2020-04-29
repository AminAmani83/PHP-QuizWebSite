<?php
require("inc/functions.inc.php");

// redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    die();
}

// log
$log->notice("Admin Logged Out"); // log

// kill session
session_unset();
session_destroy();

// redirect
header("Location: login.php");
die();