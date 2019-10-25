<?php
if (!defined('PATH_SYSTEM')) die ('Bad request');

class Index_Controller extends Controller {
    //product view
    public function indexAction(){
        $this->view->load('index');

        $this->view->show();
    }

    public function errorAction()
    {
        $this->view->load('error');

        $this->view->show();
    }

   
    public function productdetailAction()
    {
        $this->view->load('product_detail');

        $this->view->show();
    }

    //user view
    public function loginAction()
    {
        $this->view->load('login');
        //show
        $this->view->show();
    }

    public function registerAction()
    {
        $this->view->load('register');
        //show 
        $this->view->show();
    }

    //cart view
    public function cartAction()
    {
        
        //load cart page
        $this->view->load('cart');
        //show view
        $this->view->show();
    }

    //checkout view
    public function checkoutAction()
    {
        
        //load checkout page
        $this->view->load('checkout');
        $this->view->load('cart');
        //show view
        $this->view->show();
    }
    //payment
    public function olddealAction()
        {
            if(isset($_SESSION['name']))
            {
                $this->view->load('old_deals');
                $this->view->show();
            }
            else {
                $this->view->load('error');
                $this->view->show();
            }
        }

}