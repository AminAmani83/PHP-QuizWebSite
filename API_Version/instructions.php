<?php
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>About This Project - Fun Quizzes For You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A short description about the features of this project.">
    <meta name="keywords" content="Quiz, Fun, Entertainment, about, project, PHP, MySQL">
    <meta name="author" content="Amin Amani">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Google Fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Overlock:400,700%7CRoboto:400,700&display=swap"
          rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

<!-- Header -->
<header>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>Fun Quizzes For You</h1>
                <h5>and your whole family and friends</h5>
            </div>
        </div>
    </div>
</header>

<!-- Navigation Bar -->
<nav class="navbar navbar-dark bg-dark navbar-expand-md justify-content-center">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarToggler">
        &nbsp;
    </div>
</nav>

<!-- Main -->
<main>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-8 pt-5 pb-5">

                <!-- title -->
                <div class="row bg-info pt-3 pb-2" id="title-bar">
                    <div class="col-12 p-1 pl-4">
                        <h2 class="text-left"><strong>Instructions</strong></h2>
                    </div>
                </div>

                <!-- Intro -->
                <div class="row bg-warning pt-2 justify-content-center" id="intro">
                    <div class="col-10 pt-2 pb-3 text-center">
                        PHP Quiz API usage instructions
                    </div>
                </div>

                <!-- Main Text -->
                <div class="row bg-info pt-4 pb-2 justify-content-center" id="about-text">
                    <div class="col-10 pt-1 pb-5 text-justify">
                        <h4><strong>A. Quiz Topics</strong></h4>
                        <hr>
                        <p>See all available topics, their IDs and their cover images:</p>
                        <p class="h6 ml-5 pb-2">https://www.aminamani.net/assets/demo/php-quiz-api/quiz/topics</p>
                        <p>Sample Response:</p>
                        <p class="ml-5">
                            [{"id":"1","topic":"Animation","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/animation/1.jpg"},{"id":"4","topic":"Logo","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/logo/1.png"},{"id":"2","topic":"Movie","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/movie/1.jpg"},{"id":"3","topic":"People","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/people/1.jpg"},{"id":"5","topic":"Puzzle","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/puzzle/1.jpg"}]
                        </p>
                    </div>

                    <div class="col-10 pt-1 pb-5 text-justify">
                        <h4><strong>B. Quiz Questions (only available to registered users)</strong></h4>
                        <hr>
                        <p>See (n) questions from topic ID number (m):</p>
                        <p class="h6 ml-5 pb-2">https://www.aminamani.net/assets/demo/php-quiz-api/quiz/m/n</p>
                        <p>Example URL:</p>
                        <p class="h6 ml-5 pb-2">https://www.aminamani.net/assets/demo/php-quiz-api/quiz/1/3</p>
                        <p>Sample Response:</p>
                        <p class="ml-5">
                            [{"answer":"Ice
                            Age","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/animation/3.jpg"},<br>{"answer":"Lion
                            King","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/animation/15.jpg"},<br>{"answer":"Big
                            Hero
                            6","image":"https://www.aminamani.net/assets/demo/php-quiz-api/img/animation/17.jpg"}]
                        </p>
                        <p>Sample Response for Un-Authorized Access:</p>
                        <p class="ml-5">{"message":"No token provided."}</p>
                    </div>

                    <div class="col-10 pt-1 pb-5 text-justify">
                        <h4><strong>C. Settings (only available to admin users)</strong></h4>
                        <hr>
                        <p>Note: For this demo, anyone with a Gmail account is considered as Admin.</p>
                        <p>View Current Admin Settings for the Website version:</p>
                        <p class="h6 ml-5 pb-2">
                            https://www.aminamani.net/assets/demo/php-quiz-api/quiz/private/game-settings</p>
                        <p>Sample Response:</p>
                        <p class="ml-5">
                            [{id: "1", setting_key: "admin_password","TheHashedPassword"},<br>{id: "2", setting_key:
                            "requested_number_of_questions", setting_value: "6"},<br>{id: "3", setting_key:
                            "seconds_per_question", setting_value: "15"},<br>{id: "4", setting_key: "placeholder_image",
                            setting_value: "question-placeholder.jpg"},<br>{id: "5", setting_key:
                            "javascript_assist_mode", setting_value: "1"}]
                        </p>
                        <p>Sample Response for Un-Authorized Access:</p>
                        <p class="ml-5">{"message":"No token provided."}</p>
                    </div>
                </div>

                <!-- Foot Note -->
                <div class="row bg-warning p-3 justify-content-center" id="foot-note">
                    <div class="col-10 text-center">
                        <a href="https://github.com/AminAmani83/PHP-QuizWebSite" target="_blank"
                           title="Code on Github" class="text-primary">Check out the code on GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Copyright -->
<footer>
    <div class="container-fluid">
        <div class="row bg-dark pt-3 justify-content-center" id="footer">
            <div class="col-12 text-center">
                <div class="row justify-content-center">
                    <div class="col-12 d-flex justify-content-center my-2">
                        <a href="https://www.facebook.com/">
                            <i class="d-block fa fa-facebook-official text-muted fa-lg mr-2"></i>
                        </a>
                        <a href="https://www.instagram.com/">
                            <i class="d-block fa fa-instagram text-muted fa-lg mx-2"></i>
                        </a>
                        <a href="https://twitter.com/">
                            <i class="d-block fa fa-twitter text-muted fa-lg ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <p class="text-muted">Copyright &copy; 2020 Amin Amani - All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Vendor JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5a1816f9ba.js" crossorigin="anonymous"></script>
<!-- Custom JS -->
</body>

</html>
