<?php
class homeController extends Controller {
        
        public function __construct() {
                parent::__construct();
        }

        public function index() {
        	$data['c'] = array('a' => 1, 'b' => 2);
        	$this->show('home', $data);
        }
}

