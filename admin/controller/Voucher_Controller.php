<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Voucher_Controller extends Controller
{
    public function addAction()
    {
        if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
        $this->model->load('add_voucher');
        else {
            $this->view->load('error');
            $this->view->show();
        }
    }
}