<?php
/**
 * URL路由分发类
 * @author renhai <540693750@qq.com>
 * @version 1.0
 */
final class Route {
	public $url_query;
	public $url_type;
	public $route_url = array();
	private $validate_url = array(1, 2);
	
	public function __construct() {
		$this->url_query = parse_url($_SERVER['REQUEST_URI']);;
	}
	
	/**
	 * 设置URL类型
	 * @param number $url_type
	 */
	public function setUrlType($url_type = 2) {
		if(in_array($url_type, $this->validate_url)) {
			$this->url_type = $url_type;
		} else {
			trigger_error('Url mode is illegal');
		}
	}
	
	/**
	 * 获取数组形式的URL
	 */
	public function getUrlArray() {
		$this->makeUrl();
		return $this->route_url;
	}
	
	
	public function makeUrl() {
		switch ($this->url_type) {
			case 1:
				$this->queryToArray();
				break;
			case 2:
				$this->pathinfoToArray();
				break;
		}
	}
	
	/**
	 *  将query形式的URL转化成数组
	 */
	public function queryToArray() {
		$arr = !empty($this->url_query['query']) ? explode('&', $this->url_query['query']) : array();
		$array = $tmp = array();
		if(count($arr) > 0) {
			//将参数分解为数组a=b改为 array('a' => 'b')
			foreach($arr as $item) {
				$tmp = explode('=', $item);
				$array[$tmp[0]] = $tmp[1];
			}
			if(isset($array['app'])) {
				$this->route_url['app'] = $array['app'];
				unset($array['app']);
			}
			if (isset($array['controller'])) {
	            $this->route_url['controller'] = $array['controller'];
	            unset($array['controller']);
	        } 
            if (isset($array['action'])) {
                $this->route_url['action'] = $array['action'];
                unset($array['action']);
            }
            if(count($array) > 0) {
                $this->route_url['params'] = $array;
            }
		} else {
			$this->route_url = array();
		}
	}
	
	/**
	 * 将pathinfo的URL形式转化为数组
	 */
	public function pathinfoToArray() {
		return array();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}