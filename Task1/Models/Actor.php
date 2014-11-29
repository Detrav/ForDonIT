<?php

class Actor
{
	public $Id;
	public $Name;
	public $CountFilm;
	public function __construct($Id,$Name,$CountFilm = -1)
	{
		$this->Id = $Id;
		$this->Name = $Name;
		$this->CountFilm = $CountFilm;
	}
}
?>