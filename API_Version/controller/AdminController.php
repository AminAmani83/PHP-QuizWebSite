<?php

class AdminController extends MainController
{
    private $modelTopic;
    private $modelQuestion;

    public function __construct()
    {
        parent::__construct();
        $this->modelQuestion = new Question($this->db, 'quiz');
        $this->modelTopic = new Topic($this->db, 'quiz_topics');
    }

    /**
     * Display the Game Setting Variables
     * Visibility: Registered users with an Admin role
     * http://localhost/MyCode/7_API/quiz/private/game-settings
     */
    public function showGameSettings()
    {
        // Only for Admins
        $this->checkRole("admin");

        // temporary:
        $topicsList = $this->modelTopic->getAllTopicsWithImages();
        echo json_encode($topicsList);
        die();
    }
}