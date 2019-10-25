<?php 
    if (!defined('PATH_SYSTEM')) die ('Bad request');
    class Cart_Controller extends Controller
    {
        public function addAction()
        {
            $this->model->load('add_to_cart');
        }
        public function editAction()
        {
            $this->model->load('edit_cart');
        }
        public function deleteAction()
        {
            $this->model->load('delete_from_cart');
        }
        public function checkoutAction()
        {
            if(!isset($_POST['email'])||!isset($_POST['name']))
            return false;
            $content = $this->view->load('mail_confirm');
            $title = 'Xác Nhận Đặt Hàng';
            $mTo = $_POST['email'];
            $nTo = $_POST['name'];
            $this->library->load('mail');
            $mail = new Mail_Library();
            $mail->sendMail($title,$content,$nTo,$mTo);
            $this->model->load('checkout');
        }
    }