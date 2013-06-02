<?php namespace Earm\Ticketing\Models;


class Order extends \Eloquent
{
	protected $table = 'orders';

	public $timestamps = true;

	protected $fillable = array(
						'title',
						'first_name',
						'last_name',
						'address_line1',
						'address_line2',
						'address_line3',
						'address_line4',
						'address_city',
						'address_country',
						'address_postcode',
						'email',
						'phone',
						'discount',
						'total_paid',
						);

	protected static $rules = array(
						'title' => array('required','max:16'),
						'first_name' => array('required','size:64'),
						'last_name' => array('required', 'size:64'),
						);



	protected $errors = null;

	public function tickets()
	{
		return $this->hasMany('\Earm\Ticketing\Models\Ticket');
	}

	public function save(array $options = array())
	{

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
    	$this->first_name = '';
    	$this->last_name = '';
    	$this->id = null;
    }

}