<?php

// Load Twig Error Classes
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

// All our Functions
require("inc/functions.inc.php");

// Game Setup
// if topic is in URL, start a new game. During the game we never pass the topic in the URL.
// The topic name will be held in the session var. The "Play Again" button passes the topic in the URL again.
if (isset($_GET['topic']) && $_GET['topic'] !== "") {
    setupNewGame($_GET['topic']);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Start Game (if Start button is clicked)
    if (isset($_POST['btn-start'])) {
        startGame();
    }
    // End Game (if Give Up button is clicked)
    if (isset($_POST['btn-giveup'])) {
        endGame("Game Over");
    }
    // Check Answer (if answer is submitted)
    if (isset($_POST['user-answer'])) { // either input field, next or prev button were pressed
        processUserAnswer();
        // End Game (if user has won)
        if (answeredCount() === count($_SESSION['quizData'])) {
            endGame("You Won!");
        }
    }
}

// check timeout
if ($_SESSION['gameStatus'] === "active") {
    if (time() - $_SESSION['startTime'] > $_SESSION['time']) {
        endGame("Time Out");
    }
}

$pageNumber = setPageNumber();


/////////////////////////////////////////
//            TWIG Template            //
/////////////////////////////////////////

// Preparing the Paginator thumbnail data - Keeping all the logic out of the template files
$paginatorData = array();
foreach ($_SESSION['quizData'] as $qNumber => $qData) {
    array_push($paginatorData,
        array("thumbnailFileName" => ($_SESSION['gameStatus'] === "notStarted") ? $_SESSION['placeHolderImage'] : $qData['image'],
            "thumbnailClass" => thumbnailClassSelector($qNumber, $pageNumber),
            "thumbnailIsClickable" => thumbnailIsClickable($qNumber, $pageNumber),
            "thumbnailLink" => "?pageNumber=$qNumber#title-bar")
    );
}

// Rendering the Template with required arguments
try {
    echo $twig->render("quiz.html.twig", array(
        "pageNumber" => $pageNumber,
        "placeHolderImage" => $_SESSION['placeHolderImage'],
        "imageFileName" => $_SESSION['quizData'][$pageNumber]['image'],
        "quizTitle" => htmlentities($_SESSION['quizTitle'], ENT_QUOTES, "utf-8"),
        "gameStatus" => $_SESSION['gameStatus'],
        "formActionTargetWithTopic" => htmlentities($_SERVER['PHP_SELF'] . "?topic=" . $_SESSION['quizTitle'] . "#title-bar", ENT_QUOTES, "utf-8"),
        "formActionTargetWithoutTopic" => htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "utf-8") . "#title-bar",
        "message" => htmlentities($_SESSION['message'], ENT_QUOTES, "utf-8"),
        "score" => answeredCount() . "/" . count($_SESSION['quizData']),
        "timer" => intdiv(timeLeft(), 60) . ":" . sprintf('%02d', timeLeft() % 60),
        "inputDisabledStatus" => inputDisabledStatus(),
        "thisQuestionIsAnswered" => (questionIsAnswered($pageNumber)),
        "answer" => htmlentities($_SESSION['quizData'][$pageNumber]['answer'], ENT_QUOTES, "utf-8"),
        "cipheredAnswer" => ($_SESSION['gameStatus'] === "active") ? encrypt($_SESSION['quizData'][$pageNumber]['answer'], 1) : "",
        "answerClass" => answerClassSelector($pageNumber),
        "javaScriptAssistMode" => $_SESSION['javaScriptAssistMode'],
        "paginatorData" => $paginatorData
    ));
} catch (LoaderError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (RuntimeError $e) {
    echo "Something went wrong: " . $e->getMessage();
} catch (SyntaxError $e) {
    echo "Something went wrong: " . $e->getMessage();
}