<?php
    if (!defined('PATH_SYSTEM')) die('Bad requested!');

    /*
    *@filesource system/core/Controller.php
    */
    class Controller
    {
        // Đối tượng view
        protected $view     = NULL;
     
        // Đối tượng model
        protected $model    = NULL;
     
        // Đối tượng library
        protected $library  = NULL;
     
        // Đối tượng helper
        protected $helper   = NULL;
     
        // Đối tượng config
        protected $config   = NULL;
        
        /*
        * Hàm khởi tạo
        *
        * @desc     Load các thư viện cần thiết
        */
        public function __construct()
        {
            // Loader cho config
            require_once PATH_SYSTEM . '/core/loader/Config_Loader.php';
            $this->config   = new Config_Loader();
            $this->config->load('config');

            // Loader Library
            require_once PATH_SYSTEM . '/core/loader/Library_Loader.php';
            $this->library = new Library_Loader();

            // Loader helper
            require_once PATH_SYSTEM . '/core/loader/Helper_Loader.php';
            $this->helper = new Helper_Loader();
           

            // Loader model
            require_once PATH_SYSTEM . '/core/loader/Model_Loader.php';
            $this->model = new Model_Loader();
            
            // Loader view
            require_once PATH_SYSTEM . '/core/loader/View_Loader.php';
            $this->view = new View_Loader();
            
        }
    }
