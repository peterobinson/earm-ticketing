<?php namespace Earm\Ticketing\Models;

use Carbon\Carbon;

class TicketType extends \Eloquent
{
	protected $table = "ticket_types";

	public $timestamps = false;

	public $startDate;
	public $endDate;

	protected $fillable = array(
						'start_timestamp',
						'end_timestamp',
						'duration',
						'price',
						'name',
						'start_date',
						'start_hour',
						'start_minutes',
						'end_date',
						'end_hour',
						'end_minutes',
						'max_number',
						'line_item_id',
						'enabled',
						);

	protected static $rules = array(
						'start_timestamp' => array('integer'),
						'end_timestamp' => array('integer'),
						'duration' => array('integer','min:0'),
						'price' => array('required','integer','min:0'),
						'name' => array('required', 'max:64'),
						'max_number' => array('integer','min:0'),
						'line_item_id' => array('required', 'integer','min:1'),
						'enabled' => array('integer', 'min:0', 'max:1'),
						);

	protected $errors = array();

	public function setStartDateAttribute($date) {
		$this->startDate = $date;
	}

	public function setEndDateAttribute($date) {
		$this->endDate = $date;
	}

	public function save(array $options = array())
	{
		// $this->errors = array($this->updateTimestamp());
		// return false;

		// allow direct timestamp update
		if (!\Input::get('start_timestamp'))
		{
			$this->updateStartTimestamp();
			// $this->start_timestamp = $this->createTimestamp('start');
		}
		if (!\Input::get('end_timestamp'))
		{
			$this->updateEndTimestamp();
			//$this->end_timestamp = $this->createTimestamp('end');
		}
		
		// remove date properties as these aren't going in the database.
		unset($this->start_hour);
		unset($this->start_minutes);

		unset($this->end_hour);
		unset($this->end_minutes);

        $validator = \Validator::make($this->attributes, static::$rules);

    	if( ! $validator->passes())
		{

			$this->errors = array_push($this->errors, $validator->messages()->all());

			return false;
		}

		if (count($this->errors) > 0) {
			return false;
		}


		// return true;
        return parent::save($options);

    }

    public function updateStartTimestamp() 
    {
    	if ($this->startDate === null) 
    	{
    		return true;
    	}

    	if ($this->startDate == "")
    	{
    		$this->start_timestamp = 0;
    		return true;
    	}

    	$parts = explode('/', $this->startDate);

    	if (count($parts) !== 3 || !checkdate($parts[1], $parts[0], $parts[2]))
    	{
    		$this->errors[] = "Invalid start date supplied"; 
    		return false;
    	}

    	$this->start_timestamp = mktime(0,0,0,$parts[1],$parts[0],$parts[2]);

    	return true;
    }

    public function updateEndTimestamp() 
    {
    	if ($this->endDate === null) 
    	{
    		return true;
    	}

    	if ($this->endDate == "")
    	{
    		$this->end_timestamp = 0;
    		return true;
    	}

    	$parts = explode('/', $this->endDate);

    	if (count($parts) !== 3 || !checkdate($parts[1], $parts[0], $parts[2]))
    	{
    		$this->errors[] = "Invalid end date supplied"; 
    		return false;
    	}

    	$this->end_timestamp = mktime(0,0,0,$parts[1],$parts[0],$parts[2]);

    	return true;
    }

	public function initialise()
    {
    	$this->name = '';
    	$this->duration = '';
    	$this->price = '';
    	$this->max_number = '';
    	$this->id = null;
    	$this->enabled = 0;
    }

    private function createTimestamp($startEnd)
    {
    	// check if date submitted

    	if (! isset($this[$startEnd . '_day']) || ! isset($this[$startEnd . '_month']) || !isset($this[$startEnd . '_year']))
    	{
    		return 0;
    	}

    	$hour = 0; //$this[$startEnd . '_hour'] ?: 0;
    	$minutes = 0; //$this[$startEnd . '_minutes'] ?: 0;


    	$dateTime = Carbon::create($this[$startEnd . '_year'], $this[$startEnd . '_month'], $this[$startEnd . '_day'], $hour, $minutes, 0);

    	return $dateTime->timestamp;
    }

    public function validation_errors()
    {
    	return $this->errors;
    }

}