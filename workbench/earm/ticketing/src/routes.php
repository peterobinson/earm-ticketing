<?php

use \Earm\Ticketing\Models\Tickettype;

$handles = Config::get('ticketing::general.handles');

// Make sure a trailing is at the end
//$handles = '/'.rtrim($handles, '/');

Route::get($handles, function()
{
	return Tickettype::all();
});

//Route::get($handles.'/test', 'Earm\Ticketing\Controllers\Testcontroller@getIndex');

Route::filter('jsonifyajax',function($request, $response)
{
	//var_dump($request);
	//echo "squiggle";
	//var_dump($response);
	return $response;
});

Route::group(array('after' => 'jsonifyajax'), function() use ($handles)
{
	Route::resource($handles.'/lineitem', 'Earm\Ticketing\Controllers\LineitemController');
});