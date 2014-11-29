<?php
require_once(__DIR__."/Actor.php");
class Film
{
	public $Id;
	public $Name;
	public $Actors = array();

	public function __construct($Id,$Name)
	{
		$this->Id = $Id;
		$this->Name = $Name;
	}

	public function AddActor($Actor)
	{
		$actors = $this->Actors;
		$actors[] = $Actor;
		$this->Actors = $actors;
	}
}
?>