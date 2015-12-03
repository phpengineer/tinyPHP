<?php
class TestController extends Controller {
        
        public function __construct() {
                parent::__construct();
        }

        public function index() {
        	$TestModel = $this->model('Test');
        	$result = $TestModel->getTestData();
        	$data['result'] = $result;
			$this->show('index', $data);
        }
}

