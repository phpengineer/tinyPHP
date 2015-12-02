<?php
/**
 * 模板解析类
 * @author renhai <540693750@qq.com>
 * @version 1.0
 */
final class Template {
	public $template_name = null;
	public $data = array();
	public $output = null;
	
	public function init($template_name, $data = array()) {
		$this->template_name = $template_name;
		$this->data = $data;
		$this->fetch();
	}
	
	/**
	 * 加载模板文件
	 */
	public function fetch() {
		$view_file = VIEW_PATH . '/' .$this->template_name . '.php';
		if(file_exists($view_file)) {
			extract($this->data);
			ob_start();
			include $view_file;
			$content = ob_get_contents();
			ob_end_clean();
			$this->output = $content;
		} else {
			trigger_error('Template ' . $view_file . ' does not exists');
		}
	}
	
	/**
	 * 输出模板
	 */
	public function output() {
		echo $this->output;
	}
}