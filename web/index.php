<?php
require_once __DIR__ . '/../app/models/task.class.php';
require_once __DIR__ . '/../app/models/task_kind.class.php';
require_once __DIR__ . '/../app/models/task_status.class.php';
require_once __DIR__ . '/../app/models/programmer.class.php';
require_once __DIR__ . '/../app/models/project.class.php';
require_once __DIR__ . '/../app/models/task_manager.class.php';
require_once __DIR__ . '/../lib/base/Controller.php';
require_once __DIR__ . '/../lib/base/Model.php';
require_once __DIR__ . '/../lib/base/Request.php';
require_once __DIR__ . '/../lib/base/Router.php';
require_once __DIR__ . '/../lib/base/View.php';
require_once __DIR__ . '/../app/controllers/ApplicationController.php';
require_once __DIR__ . '/../app/controllers/ErrorController.php';
require_once __DIR__ . '/../app/controllers/TaskController.php';
require_once __DIR__ . '/../app/controllers/TestController.php';
//require_once "../app/models/task_manager.class.php"; // I am adding Singleton in the single-entry point of the App
//$taskManager = TaskManager::getInstance();

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_set('CET');

// defines the web root
define('WEB_ROOT', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
// defindes the path to the files
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
// defines the cms path
define('CMS_PATH', ROOT_PATH . '/lib/base/');

// starts the session
session_start();

// includes the system routes. Define your own routes in this file
include(ROOT_PATH . '/config/routes.php');

/**
 * Standard framework autoloader
 * @param string $className
 */
function autoloader($className) {
	// controller autoloading
	if (strlen($className) > 10 && substr($className, -10) == 'Controller') {
		if (file_exists(ROOT_PATH . '/app/controllers/' . $className . '.php') == 1) {
			require_once ROOT_PATH . '/app/controllers/' . $className . '.php';
		}
	}
	else {
		if (file_exists(CMS_PATH . $className . '.php')) {
			require_once CMS_PATH . $className . '.php';
		}
		else if (file_exists(ROOT_PATH . '/lib/' . $className . '.php')) {
			require_once ROOT_PATH . '/lib/' . $className . '.php';
		}
		else {
			require_once ROOT_PATH . '/app/models/'.$className.'.php';
		}
	}
}

// activates the autoloader
//spl_autoload_register('autoloader'); // Uncomment this when renaming classes

$router = new Router();
$router->execute($routes);
?>