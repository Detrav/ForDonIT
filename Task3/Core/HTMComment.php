<?php
require_once(__dir__."/HTMVoid.php");
class HTMComment extends HTMVoid
{
	public function mPrint()
	{
		echo "<".$this->tag.$this->attr.">";
	}

	public function PrintTags($tags)
	{
		return $tags;
	}
}
?>