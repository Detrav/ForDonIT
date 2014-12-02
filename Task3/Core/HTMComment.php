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
		if(!isset($tags["!--"])) $tags["!--"] = ["open"=>0,"close"=>0,"extra"=>0];
		$tags["!--"]["open"] += 1;
		$tags["!--"]["close"] += 1;
		return $tags;
	}
}
?>