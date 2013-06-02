<?php namespace Earm\Ticketing\Controllers\Apiv1;

use \Earm\Ticketing\Models\Tickets;

class TicketController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Ticket::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$type = new Ticket();

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
		// $ticketType = new Lineitem(array(
		// 							'title' => \Input::get('title', null),
		// 							'ticket_type' => \Input::get('ticket_type',null),
		// 							'enabled' => \Input::get('enabled',0)
		// 						));

		$ticket = new Ticket(\Input::get());

		$response = array(
						'originalTicket' => $ticket->toArray(),
						'error' => false,
						);

		if ($ticket->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $ticket->validation_errors();
		}

		$response['ticket'] = $ticket->toArray();

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
		$item = Ticket::findOrfail($id);

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
		$ticket = Ticket::findOrfail($id);

		$response = array(
						'originalTicket' => $ticket->toArray(),
						'error' => false,
						);

		$ticket->fill(\Input::get());

		if ($ticket->save() === false)
		{
			$response['error'] = true;
			$response['messages'] = $ticket->validation_errors();
		}
		
		$response['ticket'] = $ticket->toArray();

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
		$ticket = Ticket::findOrfail($id);
		$id = $ticket->id;
		$ticket->delete();

		return array('deleted'=>$id);

	}

	

}