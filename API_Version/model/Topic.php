<?php


class Topic extends DB\SQL\Mapper
{
    function __construct(\DB\SQL $db, $table, $fields = NULL, $ttl = 60)
    {
        parent::__construct($db, $table, $fields, $ttl);
    }

    /**
     * (C)RUD
     * Adds a topic to the database (based on POST data)
     */
    function addTopic()
    {
        $this->copyfrom("POST");
        $this->save();
    }

    /**
     * C(R)UD
     * get a topic with a specific ID from database
     * @param $id
     * @return mixed
     */
    function getTopicById($id)
    {
        $this->load(array("id=?", $id));
        return $this->query[0];
    }

    /**
     * CR(U)D
     * update a topic with a specific ID in the database (based on POST data)
     * @param $id
     */
    function updateTopic($id)
    {
        $this->getTopicById($id);
        $this->copyfrom("POST");
        $this->update();
    }

    /**
     * CRU(D)
     * Removes a topic with a specific ID from database
     * @param $id
     */
    function eraseTopic($id)
    {
        $this->getTopicById($id);
        $this->erase();
    }


    /**
     * (SPECIAL)
     * get all topics from database with 1 image for each topic as the cover image
     * @return array
     */
    function getAllTopicsWithImages()
    {
        return $this->db->exec("
                    SELECT
                        qt.id,
                        qt.topic,
                        q.image
                    FROM
                        quiz_topics AS qt
                    LEFT JOIN
                        quiz AS q ON q.topic_id = qt.id
                    GROUP BY
                        topic;
                  ");
    }

}