<?php
if (!defined('PATH_SYSTEM')) die('Bad request');

class Statistic_Controller extends Controller
{
    //statistic of category follow by everyday
    public function categoryAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['is_admin']))
        //load 
        {
            $this->view->load('statistic');
        }
        else
            $this->view->load('error');
        //show
        $this->view->show();
    }
    public function hotsaleAction()
    {
        if(isset($_SESSION['name'])&&isset($_SESSION['is_admin']))
            //load 
            {
                $this->view->load('top_sale');
            }
            else
            $this->view->load('error');
            //show
            $this->view->show();
    }
}