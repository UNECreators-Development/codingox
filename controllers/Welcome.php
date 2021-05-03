<?php
defined('APP_PATH') or exit('No direct script access allowed');
class Welcome extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->helper('url');
    }

    public function index()
    {
        $this->view('welcome');
    }
}
