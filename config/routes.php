<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
    '/test' => 'test#index',
    '/' => 'application#index',                      // default route
    '/grid' => 'application#index',                  // index (view_all_in_grid)
    '/kind' => 'application#columnKind',              // column grouped by kind
    '/progress' => 'application#columnProgress',      // column grouped by progress
	//'/task/create' => 'application#create',         // tried moving createAction from TaskController to ApplicationController but didn't work either
    '/task/create' => 'task#create',
    '/task/show' => 'task#show',
    //$router->post('/crud_task/show', 'TaskController@showAction'),
    //'task/getAll' => 'task#getAll',
    '/task/update' => 'task#update',
    '/task/delete' => 'task#delete',
);
?>
