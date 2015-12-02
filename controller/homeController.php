<?php
class homeController extends Controller {
        
        public function __construct() {
                parent::__construct();
        }

        public function index() {
                var_dump('aa');
                exit();
        }
}

