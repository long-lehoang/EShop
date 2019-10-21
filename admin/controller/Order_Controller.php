<?php 
if (!defined('PATH_SYSTEM'))  die ('Bad request');

class Order_Controller extends Controller 
{
    public function acceptAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['is_admin']))
            //load model delete order
            $this->model->load('accept_order');
        else
            {
                $this->view->load('error');
                $this->view->show();
            }
    }

}