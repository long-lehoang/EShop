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
            
            $this->model->load('checkout');
        }
    }