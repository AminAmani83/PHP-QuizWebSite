<?php

class AdminController extends MainController
{
    private $modelSetting;

    public function __construct()
    {
        parent::__construct();
        $this->modelSetting = new Setting($this->db, 'quiz_settings');
    }

    /**
     * Display the Game Setting Variables
     * Visibility: Registered users with an Admin role
     * http://localhost/API/quiz/private/game-settings
     */
    public function showGameSettings()
    {
        // Only for Admins
        $this->checkRole("admin");

        // temporary:
        $settingsList = $this->modelSetting->getAllSettings();
        echo json_encode($settingsList);
        die();
    }
}