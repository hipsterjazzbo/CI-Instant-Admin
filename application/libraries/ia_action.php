<?php

class IA_Action {

	public $key;
	public $title;
	public $icon;

	function __construct($options)
	{
		foreach ($options as $option => $value)
		{
			$this->$option = $value;
		}
	}

}
