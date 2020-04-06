<?php

// Load Twig Error Classes
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

// All our Functions
require("inc/functions.inc.php");

try {
    echo $twig->render("about.html.twig", array(
        "printable" => true // loads print.css
    ));
} catch (LoaderError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (RuntimeError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (SyntaxError $e) {
    echo "Something went wrong: " . $e->getMessage();
}