<?php
    if (!defined('PATH_SYSTEM')) die ('Bad request');

    class Model_Loader {
        
        public function load($model)
        {
            if(!file_exists(PATH_APPLICATION . '/model/' . $model .'.php'))
            die('Model not exists');
            require_once (PATH_APPLICATION . '/model/' . $model .'.php');                
        }
        
    }