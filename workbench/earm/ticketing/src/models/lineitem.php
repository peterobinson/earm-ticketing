<?php namespace Earm\Ticketing\Models;

class Lineitem extends \Eloquent
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
						'ticket_type' => array('in:Event,Duration'),
						'enabled' => array('integer', 'min:0', 'max:1'),
						);



	protected $errors = null;

	public function save(array $options = array())
	{

		//if ( ! $this->dirty()) return true;

  
        $validator = \Validator::make($this->attributes, static::$rules);

        	if( ! $validator->passes())
			{

				$this->errors = $validator->errors();

				return false;
			}

			echo "valid";
        return parent::save($options);

    }

    public function validation_errors()
    {
    	return $this->errors;
    }
}