<?php
class HTMElement
{
	public $tag = NULL;
	public $attr = NULL;
	public $content = array();


	public function __construct($name,$param)
	{
		
		$this->name = $name;
		$this->param = $param;
	}

	public function __construct()
	{
		
		$this->name = "Unknown";
		$this->param = "";
	}
	//print html, return bool
	public function mPrint()
	{
		
	}
	//return array(tag,close,cur)
	public function Parse($html,$current)
	{
		
	}
	//return array(tag,close,cur)
	private function GetTagName($html,$current)
	{
		
	}
	//return array(tag,close,cur)
	private function GetTagAttr($html,$current)
	{
		
	}
	//return mixed
	private function GetTagType($tag)
	{
		switch($tag)
		{
			case "br": //return some enum with value void;
			break;
		}
	}

}
?>