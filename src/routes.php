<?php

Route::group(['middleware' => 'web'],function(){

	//MENU

	Route::get('/authmanager', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@index',
		'as' => 'authmanager'
	]);


	Route::get('/authmanager/load/{system}', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@load',
		'as' => 'authmanager.load'
	]);


	Route::post('/authmanager/menu/update', [
		'uses' => 'rijolee\AuthManager\Controller\MenusController@update',
		'as' => 'authmanager.menu.update'
	]);

	Route::post('/authmanager/menu/store', [
		'uses' => 'rijolee\AuthManager\Controller\MenusController@store',
		'as' => 'authmanager.menu.store'
	]);

	Route::post('/authmanager/menu/storebelow/{id}', [
		'uses' => 'rijolee\AuthManager\Controller\MenusController@store',
		'as' => 'authmanager.menu.storebelow'
	]);

	Route::post('/authmanager/menu/destroy', [
		'uses' => 'rijolee\AuthManager\Controller\MenusController@destroy',
		'as' => 'authmanager.menu.destroy'
	]);



	Route::get('/authmanager/menu/{id}', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@menu',
		'as' => 'authmanager.menu'
	]);

	Route::get('/authmanager/showmenu/{id}/{system}', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@showmenu',
		'as' => 'authmanager.showmenu'
	]);

	Route::get('/authmanager/menucreate', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@create',
		'as' => 'authmanager.menucreate'
	]);

	Route::get('/authmanager/menucreatebelow/{id}/{sys}', [
		'uses' => 'rijolee\AuthManager\Controller\AuthManagerController@createbelow',
		'as' => 'authmanager.menucreatebelow'
	]);


	Route::get('/authmanager/treesmenu/{sys}', [
		'uses' => 'rijolee\AuthManager\Controller\MenusController@trees',
		'as' => 'authmanager.menu.trees'
	]);


	//EVENT

	Route::get('/authmanager/events', [
		'uses' => 'rijolee\AuthManager\Controller\EventsController@index',
		'as' => 'authmanager.events'
	]);

	Route::post('/authmanager/eventsaction', [
		'uses' => 'rijolee\AuthManager\Controller\EventsController@action',
		'as' => 'authmanager.events.action'
	]);

	//EVENTMENUS
	Route::get('/authmanager/eventmenus/{id}', [
		'uses' => 'rijolee\AuthManager\Controller\EventMenusController@show',
		'as' => 'authmanager.eventmenus.show'
	]);

	Route::post('/authmanager/eventmenusaction', [
		'uses' => 'rijolee\AuthManager\Controller\EventMenusController@action',
		'as' => 'authmanager.eventmenus.action'
	]);

	//GROUP ROLES

	Route::get('/authmanager/group', [
		'uses' => 'rijolee\AuthManager\Controller\GroupRolesController@index',
		'as' => 'authmanager.group'
	]);

	Route::post('/authmanager/groupaction', [
		'uses' => 'rijolee\AuthManager\Controller\GroupRolesController@action',
		'as' => 'authmanager.group.action'
	]);

	//USER GROUP

	Route::get('/authmanager/usergroups/{id}', [
		'uses' => 'rijolee\AuthManager\Controller\UserGroupController@show',
		'as' => 'authmanager.usergroups'
	]);

	Route::post('/authmanager/addusergroups/', [
		'uses' => 'rijolee\AuthManager\Controller\UserGroupController@store',
		'as' => 'authmanager.usergroups.store'
	]);

	Route::post('/authmanager/delusergroups/', [
		'uses' => 'rijolee\AuthManager\Controller\UserGroupController@destroy',
		'as' => 'authmanager.usergroups.destroy'
	]);

	//PERMISSION

	Route::get('/authmanager/permission', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@index',
		'as' => 'authmanager.permission'
	]);

	Route::post('/authmanager/menugroups/destroy', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@destroy_menugroups',
		'as' => 'authmanager.menugroups.destroy'
	]);

	Route::post('/authmanager/menugroups/store', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@store_menugroups',
		'as' => 'authmanager.menugroups.store'
	]);

	Route::get('/authmanager/menugroups/show/{id}', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@show_menugroups',
		'as' => 'authmanager.menugroups.show'
	]);

	Route::get('/authmanager/eventmenugroups/show/{grpid}/{menuid}', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@show',
		'as' => 'authmanager.eventmenugroups.show'
	]);

	Route::post('/authmanager/eventmenugroups/store', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@store_eventmenugroups',
		'as' => 'authmanager.eventmenugroups.store'
	]);

	Route::post('/authmanager/eventmenugroups/destroy', [
		'uses' => 'rijolee\AuthManager\Controller\PermissionController@destroy_eventmenugroups',
		'as' => 'authmanager.eventmenugroups.destroy'
	]);



});


