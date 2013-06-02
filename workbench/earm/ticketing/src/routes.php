<?php

//use \Earm\Ticketing\Models\TicketType;

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
	Route::get($handles.'/apiv1/lineitems/{id}/tickettypes', 'Earm\Ticketing\Controllers\Apiv1\LineitemController@tickettypes');
	Route::resource($handles.'/apiv1/tickettypes', 'Earm\Ticketing\Controllers\Apiv1\TickettypeController');
	Route::resource($handles.'/apiv1/orders', 'Earm\Ticketing\Controllers\Apiv1\OrderController');
	Route::get($handles.'/apiv1/orders/{id}/tickets', 'Earm\Ticketing\Controllers\Apiv1\OrderController@tickets');
	Route::resource($handles.'/apiv1/tickets', 'Earm\Ticketing\Controllers\Apiv1\TicketController');
});