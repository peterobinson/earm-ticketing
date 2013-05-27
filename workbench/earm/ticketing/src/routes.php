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


	return $response;
});

Route::group(array('after' => 'jsonifyajax'), function() use ($handles)
{
	Route::resource($handles.'/apiv1/lineitems', 'Earm\Ticketing\Controllers\Apiv1\LineitemController');
	Route::resource($handles.'/apiv1/tickettypes', 'Earm\Ticketing\Controllers\Apiv1\TickettypeController');
});