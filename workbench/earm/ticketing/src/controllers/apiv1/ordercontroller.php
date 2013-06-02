<?php namespace Earm\Ticketing\Controllers\Apiv1;

use \Earm\Ticketing\Models\Ticket;

class OrderController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Order::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$type = new Order();

		$type->initialise();

		return $type;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$order = new Order(\Input::get());

		$response = array(
						'originalOrder' => $order->toArray(),
						'error' => false,
						);

		if ($order->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $order->validation_errors();
		}

		$response['order'] = $order->toArray();

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
		$item = Order::findOrfail($id);

		return $item;
	}

	public function tickets($id)
	{
		
		return Order::findOrfail($id)->tickets;
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
		$order = Order::findOrfail($id);

		$response = array(
						'originalOrder' => $order->toArray(),
						'error' => false,
						);

		$order->fill(\Input::get());

		if ($order->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $order->validation_errors();
		}
		
		$response['order'] = $order->toArray();

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
		$order = Order::findOrfail($id);
		$id = $order->id;
		$order->delete();

		return array('deleted'=>$id);

	}

	

}