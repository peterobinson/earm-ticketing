<?php namespace Earm\Ticketing\Controllers\Apiv1;

use \Earm\Ticketing\Models\LineItem;

class LineitemController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return LineItem::all();
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

		$lineItem = new LineItem(\Input::get());

		$response = array(
						'originalLineItem' => $lineItem->toArray(),
						'error' => false,
						);

		if ($lineItem->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $lineItem->validation_errors();
		}

		$response['lineItem'] = $lineItem->toArray();

		return $response;

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = LineItem::findOrfail($id);

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
		$lineItem = LineItem::findOrfail($id);

		$response = array(
						'originalLineItem' => $lineItem->toArray(),
						'error' => false,
						);

		$lineItem->fill(\Input::get());

		if ($lineItem->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $lineItem->validation_errors();
		}
		
		$response['lineItem'] = $lineItem->toArray();

		return $response;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$item = LineItem::findOrfail($id);
		$id = $item->id;
		$item->delete();

		return array('deleted'=>$id);

	}

	

}