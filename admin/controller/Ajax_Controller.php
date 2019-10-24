<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Ajax_Controller extends Controller
{
    public function indexAction()
    {
        $this->model->load('index');
    }
}