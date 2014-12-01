<?php
require_once(__dir__."/HTMElement.php");
class HTMVoid extends HTMElement
{
	public function mPrint()
	{
		echo "
		";
		echo "<".$this->tag." ".$this->attr.">";
		echo "
		";
	}

	public function Parse($html,$current = 0)
	{
		return [$this->tag,True,$current];
	}
}
?>