<?php namespace Earm\Ticketing\Models;

//use Earm\Ticketing\Models\TicketType;

class LineItem extends \Eloquent
{
	protected $table = 'line_items';

	public $timestamps = false;

	protected $fillable = array(
						'title',
						'ticket_type',
						'enabled',
						);

	protected static $rules = array(
						'title' => array('required','max:128'),
						'ticket_type' => array('required','in:Event,Duration'),
						'enabled' => array('integer', 'min:0', 'max:1'),
						);



	protected $errors = null;

	public function ticketTypes()
	{
		//$type = new TicketType;
		//print_r(get_declared_classes());
		//return new TicketType;
		return $this->hasMany('\Earm\Ticketing\Models\TicketType');
		//return $this->hasOne('Order');
	}

	public function save(array $options = array())
	{

		//if ( ! $this->dirty()) return true;

  
        $validator = \Validator::make($this->attributes, static::$rules);

        	if( ! $validator->passes())
			{

				$this->errors = $validator->messages()->all();

				return false;
			}

        return parent::save($options);

    }

    public function validation_errors()
    {
    	return $this->errors;
    }

    public function initialise()
    {
    	$this->title = '';
    	$this->ticket_type = '';
    	$this->enabled = 0;
    	$this->id = null;
    }
}