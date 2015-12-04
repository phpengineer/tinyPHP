<?php
class TestController extends Controller {

        public function index() {
        	$TestModel = $this->model('Test');
        	$result = $TestModel->getTestData();
        	$data['result'] = $result;
			$this->show('index', $data);
        }
        
        public function insert() {
        	$message = json_encode(array('a', 'b'));
        	Logger::write($message, 'log');
        }
}

