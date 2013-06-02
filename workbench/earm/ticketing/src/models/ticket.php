<?php namespace Earm\Ticketing\Models;


class Ticket extends \Eloquent
{
	protected $table = "tickets";

	public $timestamps = false;

	public $startDate;
	
	public $endDate;

	protected $fillable = array(
						'order_id',
						'ticket_type_id',
						'start_timestamp',
						'end_timestamp',
						'price',
						'start_date',
						'end_date',
						
						);

	protected static $rules = array(
						'order_id' => array('required','integer'),
						'ticket_type_id' => array('integer', 'min:1'),

						'price' => array('required','integer','min:0'),
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
		}
		if (!\Input::get('end_timestamp'))
		{
			$this->updateEndTimestamp();
		}
		
		// remove date properties as these aren't going in the database.
		// unset($this->start_hour);
		// unset($this->start_minutes);

		// unset($this->end_hour);
		// unset($this->end_minutes);

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
    	$this->price = '';
    }

    public function validation_errors()
    {
    	return $this->errors;
    }


}