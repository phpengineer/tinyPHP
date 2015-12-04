<?php
/**
 * 日志类
 * @author renhai
 */
class Logger {

	static protected $_instance = NULL;

	static protected $_table = NULL;
	
	
	/**
	 * 增加日志，不直接写入
	 * @param $message
	 */
	static public function add($message) {
		Logger::instance()->message($message);
	}

	/**
	 * 写入
	 */
	static public function write($message, $table) {
		self::$_table = $table;
		Logger::instance()->message($message, TRUE);
	}

	/**
	 * 单例
	 * @param array $config
	 */
	static public function instance() {
		if(self::$_instance === NULL) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 日志
	 * @var array
	 */
	protected $_messages = array();
	
	public function __construct() {
		$config = Application::$_config;
		$type = $config['log'];
	}

	/**
	 * 增加日志消息
	 * @param array $message
	 * @param boolean $writeNow
	 */
	public function message($message, $writeNow = FALSE) {
		require APP_LIB_PATH . '/misc.php';
		$server = Misc::parseServer();
		$this->_messages[] = array (
			'controller' => $server['controller'],
			'action' => $server['action'],
			'get' => json_encode($_GET),
			'post' => json_encode($_POST),
			'message' => $message,
			'ip' => Misc::getClientIp(),
			'referer' => !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ' ',
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'account_id' => 0,
			'create_time' => time(),
		);

		if($writeNow === TRUE) {
			$this->_write();
		}
		
		return $this;
	}
	
	/**
	 * 写入
	 */
	protected function _write() {
		if(!$this->_messages) {
			return TRUE;
		}

		$messages = $this->_messages;
		$this->_messages = array();
		$this->db = new mysql();
		$config_db = Application::$_config['db'];
        //初始话数据库类
        $this->db->init(
             $config_db['db_host'],
             $config_db['db_user'],
             $config_db['db_password'],
             $config_db['db_database'],
             $config_db['db_conn'],
             $config_db['db_charset']
          );
		$faileds = array();
		foreach($messages as $message) {
			$columnName = implode(',', array_keys($message));
			$value = '\''. $message['controller'] . '\',' . '\'' . $message['action'] . '\',' .
					'\'' . $message['get'] . '\',' . '\'' . $message['post'] . '\',' . '\'' . $message['message'] . '\',' .
					'\'' . $message['ip'] . '\',' . '\'' . $message['referer'] . '\',' . '\'' . $message['user_agent'] . '\',' .
					 $message['account_id'] . ',' . $message['create_time'];
			
			$result = $this->db->insert(self::$_table, $columnName, $value);
		}
		return TRUE;
	}
	
	/**
	 * 析构，写入日志
	 */
	public function __destruct() {
		$this->_write();
	}
}