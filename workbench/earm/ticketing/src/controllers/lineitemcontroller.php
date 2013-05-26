<?php namespace Earm\Ticketing\Controllers;

use \Earm\Ticketing\Models\Lineitem;

class LineitemController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Lineitem::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//


	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// $lineItem = new Lineitem(array(
		// 							'title' => \Input::get('title', null),
		// 							'ticket_type' => \Input::get('ticket_type',null),
		// 							'enabled' => \Input::get('enabled',0)
		// 						));

		$lineItem = new Lineitem(\Input::get());

		if ($lineItem->save() === false)
		{
			var_dump($lineItem->validation_errors());
		}
		else
		{
			echo "Created Successfully!";
		}

		var_dump($lineItem);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = Lineitem::findOrfail($id);

		return $item;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$item = Lineitem::findOrfail($id);

		$item->fill(\Input::get());

		if ($lineItem->save() === false)
		{
			var_dump($lineItem->validation_errors());
		}
		else
		{
			echo "Created Successfully!";
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lineitem::destroy($id);

	}

	

}