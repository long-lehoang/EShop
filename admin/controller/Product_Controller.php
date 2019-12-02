<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Product_Controller extends Controller
{
    
    public function addAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
        //load model add product
        $this->model->load('add_product');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }
    public function addquantityAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
        //load model add product
        $this->model->load('add_quantity');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }
    public function subquantityAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
        //load model add product
        $this->model->load('sub_quantity');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }
    public function editAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
        //load model edit product
        $this->model->load('edit_product');
        else
        {
            $this->view->load('error');
            $this->view->show();
        }
    }

    public function deleteAction()
        {
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load model delete product
            $this->model->load('delete_product');
            else
            {
                $this->view->load('error');
                $this->view->show();
            }
        }
}