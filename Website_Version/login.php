<?php

// Load Twig Error Classes
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

// All our Functions
require("inc/functions.inc.php");

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: admin.php");
    die();
}

$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // input validation
    $errorMessage .= validateLoginData();

    if (trim($errorMessage) === ""){ // input validation success, try to log in
        $errorMessage .= attemptLogin();
    }

    if (trim($errorMessage) === "") { // login success, prepare session, log and redirect
        $_SESSION['isLoggedIn'] = true; // session variable
        $log->notice("Admin Logged In"); // log
        header("Location: admin.php"); // redirect
        die();
    }
}

// Load Page via Template
try {
    echo $twig->render("login.html.twig", array(
        "printable" => false, // loads print.css
        "errorMessage" => $errorMessage
    ));
} catch (LoaderError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (RuntimeError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (SyntaxError $e) {
    echo "Something went wrong: " . $e->getMessage();
}