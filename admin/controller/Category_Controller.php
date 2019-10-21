<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Category_Controller extends Controller
{
    public function addAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model add category
        $this->model->load('add_category');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }

    public function editAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model edit category
        $this->model->load('edit_category');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }

    public function deleteAction()
    {
        if (isset($_SESSION['name'])&&$_SESSION['user']='admin')
        //load Model delete category
        $this->model->load('delete_category');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }
}