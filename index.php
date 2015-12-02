<?php
/**
 * 项目入口文件
 */
require dirname(__FILE__) . '/system/application.php';
require dirname(__FILE__) . '/config/config.php';

Application::run($config);