<?php


class Question extends DB\SQL\Mapper
{
    function __construct(\DB\SQL $db, $table, $fields = NULL, $ttl = 60)
    {
        parent::__construct($db, $table, $fields, $ttl);
    }

    /**
     * (C)RUD
     * Adds a questions to the database (based on POST data)
     */
    function addQuestion()
    {
        $this->copyfrom("POST");
        $this->save();
    }

    /**
     * C(R)UD
     * get a questions with a specific ID from database
     * @param $id
     * @return mixed
     */
    function getQuestionById($id)
    {
        $this->load(array("id=?", $id));
        return $this->query[0];
    }

    /**
     * CR(U)D
     * update a questions with a specific ID in the database (based on POST data)
     * @param $id
     */
    function updateQuestion($id)
    {
        $this->getQuestionById($id);
        $this->copyfrom("POST");
        $this->update();
    }

    /**
     * CRU(D)
     * Remove a questions with a specific ID from database
     * @param $id
     */
    function eraseQuestion($id)
    {
        $this->getQuestionById($id);
        $this->erase();
    }


    /**
     * (SPECIAL)
     * get a certain number of questions from a specific topic randomly
     * @param $topicId
     * @param $numberOfQuestions // will be ignored if # of available questions is lower than this
     * @return mixed assoc.array
     */
    function fetchQuizByTopic($topicId, $numberOfQuestions)
    {

        // Validation (must be a positive number)
        if ($numberOfQuestions < 0) {
            $numberOfQuestions = 0;
        }

        return $this->db->exec(
            "SELECT answer, image FROM quiz WHERE topic_id = :topicId ORDER BY RAND() LIMIT :qCount",
            array(':topicId' => (int)$topicId, ':qCount' => (int)$numberOfQuestions)
        );


//        The F3 Way:
//        $this->load(
//            array("topic_id=?", (int)$topicId),
//            array(
//                "order" => "RAND()",
//                "limit" => (int)($numberOfQuestions)
//            )
//        );
//        while ( !$this->dry() ) {  // gets dry when we passed the last record
//            echo $this->answer;
//            $this->next();
//        }

    }

}