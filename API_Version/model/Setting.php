<?php


class Setting extends DB\SQL\Mapper
{
    function __construct(\DB\SQL $db, $table, $fields = NULL, $ttl = 60)
    {
        parent::__construct($db, $table, $fields, $ttl);
    }

    /**
     * (SPECIAL)
     * get all settings from database
     * @return array
     */
    function getAllSettings()
    {
        return $this->db->exec("
                    SELECT
                        qs.id,
                        qs.setting_key,
                        qs.setting_value
                    FROM
                        quiz_settings AS qs;
                  ");
    }

}