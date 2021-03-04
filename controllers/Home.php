<?php
    class Home extends My_Controller {

        public function __construct() {
            parent::__construct();
            $this->helper('url');
        }

        public function index() {
            $this->view('index');
        }
    }
?>