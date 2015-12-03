# tinyPHP
A  tiny，useful，simple framework of  php

框架目录结构:

app

 |-controller	存放控制器文件
 
 |-model		存放模型文件
 
 |-view		存放视图文件
 
 |-lib		存放自定义类库
 
 |-config	存放配置文件
 
 |--config.php   系统配置文件
 
 |-system	系统核心目录
 
 |-index.php	入口文件
 
 用法举例：
 1、在项目的controller下建立业务的controller，如TestController

<?php

class TestController extends Controller {
        
		public function __construct() {
                parent::__construct();
        }

        public function index() {
        	$TestModel = $this->model('Test');
        	$result = $TestModel->getTestData();
        	$data['result'] = $result;
			//往模板中分配变量，index为该方法对应的模板
			$this->show('index', $data);
        }
}


2、在对应的model下建立TestModel,如下：

<?php

class TestModel extends Model {
		private  $table = 'test';	
        public function getTestData() {
             $result = $this->db->select($this->table)->getAssoc();
             return $result;
        }    
}

3、在对应的view下，建立跟contoller类名相同的目录，这个例子建立的是一个test目录
然后建立一个php文件，即模板。
$this->show('index', $data) 中的index即为模板。


好了，是不是很简单！？



