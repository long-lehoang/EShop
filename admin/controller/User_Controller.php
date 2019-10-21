<?php 
    if ( ! defined('PATH_SYSTEM')) die ('Bad requested!');
           
    class User_Controller extends Controller
    {
        
        //Validate login
        public function loginAction()
        {
            $this->model->load('login');

            echo '<script language=javascript> window.location="?c=view&a=index" </script>' ;
            
        }

        public function logoutAction()
        {
            $this->model->load('logout');
            //load page login
            echo "<script language=javascript>window.location='?c=view&a=login' </script>";
            
        }
        public function registerAction(){
            //validate register
            $this->model->load('register');
        }

        public function change_passAction(){
            //
            $this->model->load('change_password');
        }

        public function deleteAction()
        {
            $this->model->load('delete_user');
        }
    }
