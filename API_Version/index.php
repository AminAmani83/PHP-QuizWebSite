<?php

require_once 'vendor/autoload.php';

// Initiate Fat Free FrameWork
$f3 = Base::instance();

// Configure Fat Free Framework
$f3->config("inc/config.ini");



/** Routes  */
$f3->route('GET /quiz/topics', 'QuizController->showAllTopics');
$f3->route('GET /quiz/@topicId/@qCount', 'QuizController->showQuizByTopic');


/* RUN  */
$f3->run();
