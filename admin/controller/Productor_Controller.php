<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Productor_Controller extends Controller
{
    public function addAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model Add productor
        $this->model->load('add_productor');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }

    public function editAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model edit productor
        $this->model->load('edit_productor');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }

    public function deleteAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model delete productor
        $this->model->load('delete_productor');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }
}