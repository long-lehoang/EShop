<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

class User_Controller extends Controller
{
    public function loginAction()
    {
        $this->model->load('login');
        $this->model->load('load_cart');
    }

    public function registerAction()
    {
        $this->model->load('register');

    }

    public function logoutAction()
    {
        $this->model->load('logout');
    }
}