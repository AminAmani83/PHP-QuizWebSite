<?php

// Load Twig Error Classes
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

// All our Functions
require("inc/functions.inc.php");

// Setup
$topicsList = fetchAllTopics();

try {
    echo $twig->render("index.html.twig", array(
    "topicsList" => $topicsList
    ));
} catch (LoaderError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (RuntimeError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (SyntaxError $e) {
    echo "Something went wrong: " . $e->getMessage();
}