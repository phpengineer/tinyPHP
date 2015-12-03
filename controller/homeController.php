<?php
class HomeController extends Controller {
        
        public function __construct() {
                parent::__construct();
        }

        public function index() {
        	$data['c'] = array('a' => 1, 'b' => 2);
        	$this->show('index', $data);
        }
}

