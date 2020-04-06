<?php

// Load Twig Error Classes
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

// All our Functions
require("inc/functions.inc.php");

// redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    die();
}

$message = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // input validation
    $message .= validateSettingData();

    if (trim($message) === "") { // input validation success, update the DB
        $message .= updateSettings();
    }

    if (trim($message) === "") { // DB update success, message the user
        $message .= "Settings Updated. ";
        $messageClass = "message-success";
    } else {
        $messageClass = "message-danger";
    }
}

$quizSettings = fetchQuizSettings();

try {
    echo $twig->render("admin.html.twig", array(
        "printable" => false, // loads print.css
        "quizSettings" => $quizSettings,
        "message" => $message,
        "messageClass" => $messageClass
    ));
} catch (LoaderError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (RuntimeError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (SyntaxError $e) {
    echo "Something went wrong: " . $e->getMessage();
}