<?php
require_once(__dir__."/HTMElement.php");
class HTMVoid extends HTMElement
{
	public function mPrint()
	{
		if(strlen($this->attr)==0)
		{
			echo "<".$this->tag.">";
		}
		else
		{
			echo "<".$this->tag." ".$this->attr.">";
		}
	}

	public function Parse($html,$current = 0)
	{
		return [$this->tag,True,$current];
	}
}
?>