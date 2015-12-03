<?php
/**
 * 框架系统启动类
 * @author renhai <540693750@qq.com>
 * @version 1.0
 */
define('SYSTEM_PATH', dirname(__FILE__));
define('ROOT_PATH', dirname(SYSTEM_PATH));
define('SYS_LIB_PATH', SYSTEM_PATH . '/lib');
define('APP_LIB_PATH', ROOT_PATH. '/lib');
define('SYS_CORE_PATH', SYSTEM_PATH . '/core');
define('CONTROLLER_PATH', ROOT_PATH . '/controller');
define('MODEL_PATH', ROOT_PATH.'/model');
define('VIEW_PATH', ROOT_PATH.'/view');
define('LOG_PATH', ROOT_PATH.'/log');

final class Application {
	
	public static $_lib = null;
	public static $_config = null;
	
	public static function init() {
		self::autoLoadLibs();
		require SYS_CORE_PATH . '/model.php';
		require SYS_CORE_PATH . '/controller.php';
	}
	
	/**
	 * 初始化应用
	 * @param $config
	 */
	public static function run($config) {
		self::$_config = $config['system'];
		self::init();
		self::autoload();
		self::$_lib['route'] -> setUrlType(self::$_config['route']['url_type']);
		$url_array = self::$_lib['route']->getUrlArray();
		self::route($url_array);
	}
	
	public static function autoload() {
		foreach(self::$_lib as $key => $value) {
			require $value;
			$lib = ucfirst($key);
			self::$_lib[$key] = new $lib;
		}
		
		/*初始化cache*/
		if(is_object(self::$_lib['cache'])) {
			self::$_lib['cache'] -> init(
					ROOT_PATH . '/' .self::$_config['cache']['cache_dir'],
					self::$_config['cache']['cache_prefix'],
					self::$_config['cache']['cache_time'],
					self::$_config['cache']['cache_mode']
			);
		}
	}
	
	/**
	 * 加载类库  
     * @param  string  $class_name 类库名称
     * @return object
	 */
	public static function newLib($class_name) {
		$app_lib = $sys_lib = '';
		$app_lib = APP_LIB_PATH . '/' .  $class_name . '.php';
		$sys_lib = SYS_LIB_PATH . '/' . $class_name . '.php';
		if(file_exists($app_lib)) {
			require ($app_lib);
			$class_name = ucfirst($class_name);
			return new $class_name;
		} else if(file_exists($sys_lib)) {
			require ($sys_lib);
			return self::$_lib[$class_name] = new $class_name;
		} else {
			trigger_error($class_name . ' does not exist');
		}
	}
	
	/**
	 * 自动加载类库
	 */
	public static function autoLoadLibs(){
		self::$_lib = array(
				'route'  => SYS_LIB_PATH . '/route.php',
				'mysql'  => SYS_LIB_PATH . '/mysql.php',
				'template' => SYS_LIB_PATH . '/template.php',
				'cache' => SYS_LIB_PATH . '/cache.php',
		);
	}
	
	/**
	 * 根据URL分发到controller和model
	 * 
	 */
	public static function route($url_array = array()) {
		$app = '';
		$controller = '';
		$action = '';
		$model = '';
		$params = '';
		
		/*类似frontend，admin这样的模块名*/
		if(isset($url_array['app'])) {
			$app = $url_array['app'];
		}
		
		/*控制器模块*/
		if(isset($url_array['controller'])) {
			$controller = $model = $url_array['controller'];
			if($app) {
				$controller_file = CONTROLLER_PATH . '/' . $app . '/' . $controller . 'Controller.php';
				$model_file = MODEL_PATH . '/' . $app . '/' . $model .'Model.php';
			} else {
				$controller_file = CONTROLLER_PATH . '/' . $controller . 'Controller.php';
                $model_file = MODEL_PATH . '/' . $model . 'Model.php'; 
			}
		} else {
			$controller = $model = self::$_config['route']['default_controller'];
		    if($app){
               $controller_file = CONTROLLER_PATH . '/' . $app . '/' . self::$_config['route']['default_controller'] . 'Controller.php';
               $model_file = MODEL_PATH . '/' . $app . '/' . self::$_config['route']['default_controller'] . 'Model.php';
            }else{
               $controller_file = CONTROLLER_PATH . '/' . self::$_config['route']['default_controller'] . 'Controller.php';
               $model_file = MODEL_PATH . '/' . self::$_config['route']['default_controller'] . 'Model.php';
            }
		}
		
		/*方法*/
		if(isset($url_array['action'])) {
			$action = $url_array['action'];
		} else {
			$action = self::$_config['route']['default_action'];
		}
		
		/*参数*/
		if(isset($url_array['params'])) {
			$params = $url_array['params'];
		}
		
		if(file_exists($controller_file)) {
			if(file_exists($model_file)) {
				require $model_file;
			}
			require $controller_file;
			$controller = $controller . 'Controller';
			$controller = new $controller;
			if($action) {
				if(method_exists($controller, $action)) {
					isset($params) ? $controller->$action($params) : $controller->action();
				} else {
					die('method ' . $action . ' does not exist');
				}
			} else {
				die('method ' . $action . ' does not exist');
			}
			
		} else {
			die('class ' . $controller_file . ' does not exist');
		}
	
			
	}
	
}