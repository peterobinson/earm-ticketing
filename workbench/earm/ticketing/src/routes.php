<?php

use \Earm\Ticketing\Models\TicketType;

$handles = Config::get('ticketing::general.handles');

// Make sure a trailing is at the end
//$handles = '/'.rtrim($handles, '/');

Route::get($handles, function()
{
	return View::make('ticketing::main');
});

//Route::get($handles.'/test', 'Earm\Ticketing\Controllers\Testcontroller@getIndex');

Route::filter('jsonifyajax',function($request, $response)
{

	if(Request::ajax())
	{
		return Response::json($response);
	}

	//var_dump($response);
	return $response;
});

Route::group(array('after' => 'jsonifyajax'), function() use ($handles)
{
	Route::resource($handles.'/apiv1/lineitem', 'Earm\Ticketing\Controllers\Apiv1\LineitemController');
	Route::resource($handles.'/apiv1/tickettype', 'Earm\Ticketing\Controllers\Apiv1\TickettypeController');
});