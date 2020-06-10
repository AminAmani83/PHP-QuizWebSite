<?php

require_once 'vendor/autoload.php';

// Initiate Fat Free FrameWork
$f3 = Base::instance();

// Configure Fat Free Framework
$f3->config("inc/config.ini");

/** Public Routes  */
// http://localhost/MyCode/7_API/quiz/topics
$f3->route('GET /quiz/topics', 'QuizController->showAllTopics');
// Sample: http://localhost/MyCode/7_API/quiz/1/5
$f3->route('GET /quiz/@topicId/@qCount', 'QuizController->showQuizByTopic');

/** Private Routes */
// http://localhost/MyCode/7_API/quiz/private/game-settings
$f3->route('GET /quiz/private/game-settings', 'AdminController->showGameSettings');

/* RUN  */
$f3->run();
