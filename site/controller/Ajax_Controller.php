<?php
if (!defined('PATH_SYSTEM')) die('Bad Request');

class Ajax_Controller extends Controller {
    public function listcommentAction()
    {
        $this->model->load('list-comment');
    }
    public function addcommentAction()
    {
        $this->model->load('add-comment');
    }
    public function filterAction()
    {
        $this->model->load('filter-data');
    }
}