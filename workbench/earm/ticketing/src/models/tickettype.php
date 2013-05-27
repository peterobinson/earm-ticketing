<?php namespace Earm\Ticketing\Models;

use Carbon\Carbon;

class TicketType extends \Eloquent
{
	protected $table = "ticket_types";

	public $timestamps = false;

	protected $fillable = array(
						'start_timestamp',
						'end_timestamp',
						'duration',
						'price',
						'name',
						'start_day',
						'start_month',
						'start_year',
						'start_hour',
						'start_minutes',
						'end_day',
						'end_month',
						'end_year',
						'end_hour',
						'end_minutes',
						'max_number',
						);

	protected static $rules = array(
						'start_timestamp' => array('integer'),
						'end_timestamp' => array('integer'),
						'duration' => array('min:0'),
						'price' => array('required','integer','min:0'),
						'name' => array('required', 'max:64'),
						'max_number' => array('integer','min:0'),
						);

	protected $errors = null;

	public function save(array $options = array())
	{

		// allow direct timestamp update
		if (!isset($_POST['start_timestamp']))
		{
			$this->start_timestamp = $this->createTimestamp('start');
		}
		if (!isset($_POST['end_timestamp']))
		{
			$this->end_timestamp = $this->createTimestamp('end');
		}
		
		// remove date properties as these aren't going in the database.
		unset($this->start_day);
		unset($this->start_month);
		unset($this->start_year);
		unset($this->start_hour);
		unset($this->start_minutes);

		unset($this->end_day);
		unset($this->end_month);
		unset($this->end_year);
		unset($this->end_hour);
		unset($this->end_minutes);

        $validator = \Validator::make($this->attributes, static::$rules);

    	if( ! $validator->passes())
		{

			$this->errors = $validator->messages()->all();

			return false;
		}



        return parent::save($options);

    }

    private function createTimestamp($startEnd)
    {
    	// check if at least day, month and year exist

    	if (! isset($this[$startEnd . '_day']) || ! isset($this[$startEnd . '_month']) || !isset($this[$startEnd . '_year']))
    	{
    		return 0;
    	}

    	$hour = $this[$startEnd . '_hour'] ?: 0;
    	$minutes = $this[$startEnd . '_minutes'] ?: 0;


    	$dateTime = Carbon::create($this[$startEnd . '_year'], $this[$startEnd . '_month'], $this[$startEnd . '_day'], $hour, $minutes, 0);

    	return $dateTime->timestamp;
    }

    public function validation_errors()
    {
    	return $this->errors;
    }

}