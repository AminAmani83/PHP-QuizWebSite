<?php
use \Firebase\JWT\JWT;

class QuizController extends MainController
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
     * Display the List of All Topics
     * Visibility: Public
     * http://localhost/MyCode/7_API/quiz/topics
     */
    public function showAllTopics()
    {
        $topicsList = $this->modelTopic->getAllTopicsWithImages();
		
		 // Use full URL for images:
        $result = array();
        foreach ($topicsList as $topic) {
            $topic['image'] = $this->f3->get('serverProtocol') . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "/" . $this->f3->get('imageFolderName') . "/" . $topic['image'];
            $result[] = $topic;
        }
		
        echo json_encode($result);
        die();
    }

    /**
     * Display a certain number of quiz question based on Topic,
     * Visibility: Only registered users
     * Sample: http://localhost/MyCode/7_API/quiz/1/5
     * @param $f
     * @param $params
     */
    public function showQuizByTopic($f, $params)
    {
        // Only for users
        $this->authenticate();

        // Fetch questions from DB
        $quizQuestions = $this->modelQuestion->fetchQuizByTopic($params['topicId'], $params['qCount']);

        // Use full URL for images:
        $result = array();
        foreach ($quizQuestions as $quizQuestion) {
            $quizQuestion['image'] = $this->f3->get('serverProtocol') . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "/" . $this->f3->get('imageFolderName') . "/" . $quizQuestion['image'];
            $result[] = $quizQuestion;
        }

        // Display result
        echo json_encode($result);
        die();
    }

}