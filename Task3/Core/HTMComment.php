<?php
require_once(__dir__."/HTMVoid.php");
class HTMComment extends HTMVoid
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

	public function PrintTags($tags)
	{
		return $tags;
	}
}
?>