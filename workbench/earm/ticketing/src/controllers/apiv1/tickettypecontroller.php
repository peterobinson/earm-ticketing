<?php namespace Earm\Ticketing\Controllers\Apiv1;

use \Earm\Ticketing\Models\TicketType;

class TickettypeController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return TicketType::all();
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
		// $ticketType = new Lineitem(array(
		// 							'title' => \Input::get('title', null),
		// 							'ticket_type' => \Input::get('ticket_type',null),
		// 							'enabled' => \Input::get('enabled',0)
		// 						));

		$ticketType = new TicketType(\Input::get());

		$response = array(
						'originalTicketType' => $ticketType->toArray(),
						'error' => false,
						);

		if ($ticketType->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $ticketType->validation_errors();
		}

		$response['ticketType'] = $ticketType->toArray();

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
		$item = TicketType::findOrfail($id);

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
		$ticketType = TicketType::findOrfail($id);

		$response = array(
						'originalTicketType' => $ticketType->toArray(),
						'error' => false,
						);

		$ticketType->fill(\Input::get());

		if ($ticketType->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $ticketType->validation_errors();
		}
		
		$response['ticketType'] = $ticketType->toArray();

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
		$item = TicketType::findOrfail($id);
		$id = $item->id;
		$item->delete();

		return array('deleted'=>$id);

	}

	

}