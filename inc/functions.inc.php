<?php

// start session
session_start();

// include composers autoloader
require("vendor/autoload.php");

// setup twig template engine
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("currentYear", date("Y")); // global variable for the footer

// MEEKRO - database variables
DB::$user = 'ipd';
DB::$password = 'ipd';
DB::$dbName = 'ipd';
DB::$encoding = 'utf8';

// Set Up Logging (For Admin log-in and log-out)
use Monolog\Logger; // import
use Monolog\Handler\StreamHandler; // import
$log = new Logger("access_logger"); // create log channel
$log->pushHandler(new StreamHandler('logs/access.log', Logger::INFO)); // create handler

/////////////////////////////////////////
//             Functions               //
/////////////////////////////////////////


/**
 * Start the game and start the timer
 */
function startGame()
{
    $_SESSION['gameStatus'] = "active";
    $_SESSION['startTime'] = time(); // start timer count down
}

/**
 * End the game due to time-out, give-up, or winning. And display the related message
 * @param $message // to be displayed on the page
 */
function endGame($message)
{
    $_SESSION['gameStatus'] = "ended";
    $_SESSION['message'] = $message;
}

/**
 * This runs every time a new game is going to begin
 * fetches data from DB and sets the Session Vars
 * @param $topic
 */
function setupNewGame($topic)
{
    // Gather Config Variables from DB quiz_settings Table
    $quizSettings = fetchQuizSettings();
    $requestedNumberOfQuestions = (int)$quizSettings[0]['setting_value']; // The actual number of (available) questions might be lower
    $secondsPerQuestion = (int)$quizSettings[1]['setting_value'];
    $placeHolderImage = $quizSettings[2]['setting_value'];
    $javaScriptAssistMode = ($quizSettings[3]['setting_value'] === "1") ? true : false; // if input is correct, JS changes the text color

    // Gather Quiz Questions
    $_SESSION['quizData'] = fetchQuizByTopic($requestedNumberOfQuestions, $topic);

    // Set Other Session Variables
    $_SESSION['time'] = $secondsPerQuestion * count($_SESSION['quizData']); // based on available questions
    $_SESSION['gameStatus'] = "notStarted";
    $_SESSION['quizTitle'] = ucfirst(strtolower($topic)); // will be displayed on the quiz page
    $_SESSION['message'] = ""; // will be changed later by endGame()
    $_SESSION['placeHolderImage'] = $placeHolderImage;
    $_SESSION['javaScriptAssistMode'] = $javaScriptAssistMode;
}

/**
 * The number of questions that have already been answered correctly by the user
 * is calculated from the number of "1"s in $_SESSION['quizData'] for the 'is-answered' variable
 * @return int
 */
function answeredCount()
{
    $counter = 0;
    if (isset($_SESSION['quizData'])) {
        foreach ($_SESSION['quizData'] AS $question) {
            if ($question['is-answered'] == 1) {
                $counter++;
            }
        }
    }
    return $counter;
}

/**
 * Decides the class to be used for each thumbnail inside paginator based on game status:
 * if game is active: answered = green, un-answered = black
 * if game is ended: answered = green, un-answered = red
 * also the thumbnail for the current page should have the class "active" (white border)
 * @param $qNumber // index of this question in $_SESSION['quizData']
 * @param $pageNumber // current page index
 * @return string // the class to be used
 */
function thumbnailClassSelector($qNumber, $pageNumber)
{
    $defaultImageClass = "bg-dark mb-2";
    $correctImageClass = "bg-success mb-2";
    $wrongImageClass = "bg-danger mb-2";

    $activeStatus = (($qNumber === $pageNumber) ? " active" : "");

    if ($_SESSION['gameStatus'] === "active") {
        return (($_SESSION['quizData'][$qNumber]['is-answered'] === 1) ? $correctImageClass : $defaultImageClass) . $activeStatus;
    }
    if ($_SESSION['gameStatus'] === "ended") {
        return (($_SESSION['quizData'][$qNumber]['is-answered'] === 1) ? $correctImageClass : $wrongImageClass) . $activeStatus;
    } // else, game is not started
    return $defaultImageClass . $activeStatus;
}

/**
 * Determines the text color for each answer that is shown in place of the user input when the game is ended
 * @param $pageNumber
 * @return string // the class to be used
 */
function answerClassSelector($pageNumber)
{
    if (questionIsAnswered($pageNumber)) {
        return "text-success";
    }
    return "text-danger";
}

/**
 * Returns if a specific question is answered by the user or not
 * @param $pageNumber // = question index in $_SESSION['quizData']
 * @return bool
 */
function questionIsAnswered($pageNumber)
{
    return (int)$_SESSION['quizData'][$pageNumber]['is-answered'] === 1;
}

/**
 * If an answer was submitted by the user, this functions validates the 'from-page' value,
 * compares the user's answer to the correct answer based on a cleanup function for answer-flexibility,
 * and if the answer is correct, adds the appropriate value to  $_SESSION['quizData']
 */
function processUserAnswer()
{
    // Validation
    if (isset($_POST['from-page']) && isAValidPageNumber($_POST['from-page'])) {
        // check the answer & update session var
        if (stringCleanUp($_POST['user-answer']) ===
            stringCleanUp($_SESSION['quizData'][$_POST['from-page']]['answer'])) {
            $_SESSION['quizData'][$_POST['from-page']]['is-answered'] = 1;
        }
    }
}

/**
 * Decides the current page number, i.e. which question should be shown on this page.
 * POST request: if the prev or next buttons have been pressed, the current page number will be set based on the
 * from-page number and that button. It also cycles through pages (after the last page, we get the first page again)
 * GET request: if thumbnails in pagninator were clicked, validate the input and set the page number, only if the game
 * has already started or ended.
 * Fallback: 0
 * @return int
 */
function setPageNumber()
{
    // set the page number (cycle through pages)
    if (isset($_POST['btn-next']) && isset($_POST['from-page']) && isAValidPageNumber($_POST['from-page'])) { // btn-next was clicked or form was submitted by enter in text-field
        $pageNumber = ((int)$_POST['from-page'] + 1 === count($_SESSION['quizData'])) ? 0 : $_POST['from-page'] + 1;
    } else if (isset($_POST['btn-prev']) && isset($_POST['from-page']) && isAValidPageNumber($_POST['from-page'])) { // btn-prev was clicked
        $pageNumber = ((int)$_POST['from-page'] === 0) ? count($_SESSION['quizData']) - 1 : $_POST['from-page'] - 1;
    } else if (isset($_GET['pageNumber']) && isAValidPageNumber($_GET['pageNumber'])  // pageNumber is valid
        && $_SESSION['gameStatus'] !== "notStarted") { // no peeking before the game starts!
        $pageNumber = $_GET['pageNumber'];
    } else {
        $pageNumber = 0;
    }
    return (int)$pageNumber;
}

/**
 * Check if a String is a valid page number (is a number and is within range)
 * @param $pageNum
 * @return bool
 */
function isAValidPageNumber($pageNum)
{
    return ctype_digit($pageNum)  // pageNumber is a number
        && (int)$pageNum < count($_SESSION['quizData']) // pageNumber is within range
        && (int)$pageNum >= 0; // pageNumber is within range
}

/**
 * Calculate the time left on the clock. This will be displayed on the page.
 * @return int
 */
function timeLeft()
{
    if ($_SESSION['gameStatus'] === "notStarted") {
        $timeLeft = $_SESSION['time']; // default: timeLeft = total time
    } else if ($_SESSION['gameStatus'] === "active") {
        $timeLeft = $_SESSION['time'] - (time() - $_SESSION['startTime']);
    } else { // $_SESSION['gameStatus'] === "ended"
        $timeLeft = 0;
    }
    return (int)$timeLeft;
}

/**
 * Decide if a thumbnail in the paginator section should be clickable (does not link to the current page)
 * @param $qNumber // index of the question in $_SESSION['quizData']
 * @param $pageNumber // index of the currently shown question
 * @return bool
 */
function thumbnailIsClickable($qNumber, $pageNumber)
{
    return ($_SESSION['gameStatus'] === "notStarted") ? false : $qNumber !== $pageNumber;
}

/**
 * Should the input field and the buttons be enabled? Not after the game starts.
 * @return string // status of the input
 */
function inputDisabledStatus()
{
    return ($_SESSION['gameStatus'] === "notStarted") ? "disabled" : "";
}

/**
 * This function cleans up a string to prepare it for comparison. It allows a level of flexibility in the answers
 * that are provided by the users. Right now, it removes non-alphanumeric chars and converts to lowercase.
 * Example: With this setting, "johnshome" would be an acceptable answer for "John's Home".
 * This could further be changed to ignore certain words such as "a" and "the".
 * @param $str
 * @return string
 */
function stringCleanUp($str)
{
    return strtolower(preg_replace("/\W+/", "", $str));
}

/**
 * Calculating the ciphered version of a word using the Caesar Cipher algorithm
 * Source: https://code.sololearn.com/wOl61a2F297E/#php
 * Reason: Since the answer has to be transferred to JS, it will be visible in the HTML source code.
 * So, we encrypt it here, and decrypt it with JS afterwards.
 * @param $str
 * @param $offset
 * @return string
 */
function encrypt($str, $offset)
{
    $encrypted_text = "";
    for ($i = 0; $i < strLen($str); $i++) {
        $encrypted_text .= chr((ord($str[$i]) + $offset) % 255);
    }
    return $encrypted_text;
}

/**
 * LOGIN
 * Verify if user is logged in using session variables.
 * @return Boolean
 */
function isLoggedIn()
{
    return (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true);
}


/**
 * LOGIN
 * validate the input data from the login form
 * @return string : if empty everything went well, else it contains the error message
 */
function validateLoginData()
{
    $errorMessage = ""; // local var
    if (isFieldEmpty("password")) {
        $errorMessage .= "Please Enter Your Password. ";
    }
    return $errorMessage;
}

/**
 * LOGIN
 * check password match
 * @return string : if empty everything went well, else contains the error message
 */
function attemptLogin()
{
    $errorMessage = ""; // local var
    $adminInfo = fetchAdminPassword();
    if (!password_verify($_POST['password'], $adminInfo['password_hash'])) { // wrong password
        $errorMessage .= "Incorrect Password, Please Try Again. ";
    }
    return $errorMessage;
}

/**
 * ADMIN
 * validate the input data from the login form
 * @return string : if empty everything went well, else it contains the error message
 */
function validateSettingData()
{
    $errorMessage = ""; // local var
    if (isFieldEmpty("requested_number_of_questions")
        || isFieldEmpty("seconds_per_question")
        || isFieldEmpty("placeholder_image")
        || isFieldEmpty("javascript_assist_mode")
    ) {
        $errorMessage .= "All Fields Are Required. ";
    }
    if (!ctype_digit($_POST['requested_number_of_questions'])){
        $errorMessage .= "Wrong Format. ";
    }
    if (!ctype_digit($_POST['seconds_per_question'])){
        $errorMessage .= "Wrong Format. ";
    }
    if (!ctype_digit($_POST['javascript_assist_mode'])){
        $errorMessage .= "Wrong Format. ";
    }
    return $errorMessage;
}

/**
 * check if variable or form field is empty or not set in a POST request
 * @param $field
 * @return bool
 */
function isFieldEmpty($field)
{
    return (!isset($_POST[$field]) || trim($_POST[$field]) === "");
}

/////////////////////////////////////////
//           DB Functions              //
/////////////////////////////////////////

/**
 * Queries the database to receive certain number of questions from a specific topic randomly
 * The resulting array will also have a field ("is-answered" => 0) for each question value
 * The "Topic"s are all in lowercase in the DB.
 * The results would be displayed on the Quiz page. If the query result is empty, redirects to main page.
 * @param $numberOfQuestions // will be ignored if # of available questions is lower than this
 * @param $topic
 * @return mixed assoc.array
 */
function fetchQuizByTopic($numberOfQuestions, $topic)
{
    // Validation (must be a positive number)
    if ($numberOfQuestions < 0) {
        $numberOfQuestions = 0;
    }

    $results = DB::query("
        SELECT
            answer,
            image,
            0 AS 'is-answered'
        FROM
            quiz
        JOIN 
            quiz_topics ON quiz.topic_id = quiz_topics.id
        WHERE
            quiz_topics.topic = %s
        ORDER BY
            RAND()
        LIMIT %i
    ", strtolower($topic), $numberOfQuestions);

    // Check if results is empty
    if (count($results) === 0) {
        header("Location: index.php");
        die();
    } else {
        return $results;
    }
}

/**
 * Queries the DB for all the available topics, plus one image for each topic as the cover image
 * The results would be displayed on the Home page
 * @return mixed
 */
function fetchAllTopics()
{
    return DB::query("
        SELECT
            topic,
            image
        FROM
            quiz_topics AS qt
        LEFT JOIN
            quiz AS q ON q.topic_id = qt.id
        GROUP BY
            topic;
    ");
}

/**
 * get Admin password
 * @return mixed
 */
function fetchAdminPassword()
{
    return DB::queryFirstRow("
        SELECT 
            setting_value as password_hash
        FROM 
            quiz_settings 
        WHERE 
            setting_key = 'admin_password';
        ");
}

/**
 * get quiz settings (except password)
 * @return mixed
 */
function fetchQuizSettings()
{
    return DB::query("
        SELECT
            setting_key,
            setting_value
        FROM 
            quiz_settings 
        WHERE 
            setting_key != 'admin_password';
        ");
}

/**
 * Update quiz settings based on POST data
 * @return string error message (empty string if operation is successful)
 */
function updateSettings()
{
    $rowsAffected = 0;
    $rowsAffected += DB::update('quiz_settings', ['setting_value' => $_POST['requested_number_of_questions']], "setting_key=%s", "requested_number_of_questions");
    $rowsAffected += DB::update('quiz_settings', ['setting_value' => $_POST['seconds_per_question']], "setting_key=%s", "seconds_per_question");
    $rowsAffected += DB::update('quiz_settings', ['setting_value' => $_POST['placeholder_image']], "setting_key=%s", "placeholder_image");
    $rowsAffected += DB::update('quiz_settings', ['setting_value' => $_POST['javascript_assist_mode']], "setting_key=%s", "javascript_assist_mode");

    if ($rowsAffected == 4){
        return ""; // error message
    } else {
        return "Database Error. "; // error message
    }

}