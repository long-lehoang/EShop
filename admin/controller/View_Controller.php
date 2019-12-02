<?php 
    if ( ! defined('PATH_SYSTEM')) die ('Bad requested!');

    class View_Controller extends Controller
    {
        /*------------PRODUCT VIEW---------*/
        public function indexAction()
        {
            // neu da login
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            // Load view
            {   
                //load view
                $this->view->load('index');
                $this->view->show();
            }
            else
            //load error
            $this->loginAction();
        }
        
        public function addproductAction()
        {
            //session_start();
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load add product page
            $this->view->load('add_product');
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }
        public function editproductAction()
        {
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load add product page
            $this->view->load('edit_product');
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }

        /*------------ORDER VIEW-----------  */
        public function orderAction()
        {
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load list order
            $this->view->load('list_order');
            //show
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }
        public function neworderAction()
        {
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load list new order
            $this->view->load('new_order');
            else
            $this->view->load('error');
            //show
            $this->view->show();
        }
        public function oldorderAction()
        {
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load list old order
            $this->view->load('old_order');
            else
            $this->view->load('error');
            //show
            $this->view->show();
        }

        /*-------------USER VIEW------------*/ 
        public function loginAction()
        {
            //session_start();
            if(!isset($_SESSION['name'])||!isset($_SESSION['isadmin']))
            {// Load view
                $this->view->load('login');
                $this->view->show();
            }
            else
            $this->indexAction();            
        }
        public function list_userAction()
        {
            if(isset($_SESSION['user'])&&$_SESSION['user']=='admin')
            {
                $this->view->load('list_user');
                $this->view->show();
            }
        }
        public function registerAction(){
            if(isset($_SESSION['user'])&&$_SESSION['user']=='admin')
            {
                // Load register
                $this->view->load('register');
                //Show register
                $this->view->show();
            }
            else echo "Không có quyền truy cập";
        }

        /*-------------CATEGORY VIEW------------*/ 
        public function categoryAction(){
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load category
            $this->view->load('list_category');
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }
        public function editcategoryAction(){
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            //load edit category
            $this->view->load('edit_category');
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }
        public function addcategoryAction(){
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            //load add category
            $this->view->load('add_category');
            else
            $this->view->load('error');
            //view page
            $this->view->show();
        }

        /*-------------PRODUCTOR VIEW------------*/ 
        //list
        public function productorAction(){
            if(isset($_SESSION['name'])&&isset($_SESSION['isadmin']))
            //load productor
            $this->view->load('list_productor');
            else
            $this->view->load('error');
            //show
            $this->view->show();
        }
        //add
        public function addproductorAction(){
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            //load add productor
            $this->view->load('add_productor');
            else
            $this->view->load('error');
            //show
            $this->view->show();
        }
        public function editproductorAction(){
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            //load edit productor
            $this->view->load('edit_productor');
            else
            $this->view->load('error');
            //show
            $this->view->show();
        }

        /*-------------VOUCHER------------*/
        public function voucherAction()
        {
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            $this->view->load('add_voucher');
            else {
                $this->view->load('error');
            }
            $this->view->show();
        }
        
        //chang pass view
        public function change_passAction()
        {
            if(isset($_SESSION['name'])&&$_SESSION['user']='admin')
            $this->view->load('change_pass');
            else {
                $this->view->load('error');
            }
            $this->view->show();
        }
    }
