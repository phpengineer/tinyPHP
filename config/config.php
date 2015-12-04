<?php
/**
 * 配置文件
 */

/*数据库配置 */
$config['system']['db'] = array(
		'db_host' => 'localhost',
		'db_user' => 'root',
		'db_password' => 'root',
		'db_database' => 'test',
		'db_table_prefix' => '',
		'db_charset' => 'utf8',
		'db_conn' => ''
);

/**
 * 默认路由配置
 * url_type:
 * 			1,普通模式 如：index.php?c=contoller&m=index&id=1
 * 			2,PATHINFO模式 如：index.php/controller/action/id/1
 */
$config['system']['route'] =  array(
		'default_controller' => 'home',
		'default_action' => 'index',
		'url_type' => 1
);


/**
 * 缓存配置
 * cache_dir：缓存目录，相对于根目录
 * cache_prefix：缓存文件前缀
 * cache_time：单位/秒
 * cache_mode：1为serialize，2为可执行文件
 * */
$config['system']['cache'] = array(
		'cache_dir' => 'cache',
		'cache_prefix' => 'cache_',
		'cache_time' => 1800,
		'cache_mode' => 2,
);


/**
 * 日志配置，记录到数据库
 * columns对应的数组为要记录的字段
 */
$config['system']['log'] = array(
		'type' => 'database',
		'database' => array(
			'table' => 'log',
			'columns' => array(
				'controller',
				'action',
				'get',
				'post',
				'message',
				'ip',
				'user_agent',
				'referer',
				'account_id',
				'create_time',
			),
		),
);






















