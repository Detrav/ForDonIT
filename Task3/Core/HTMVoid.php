<?php
require_once(__dir__."/HTMElement.php");
class HTMVoid extends HTMElement
{
	public function __construct($tag = "Unknown",$attr = "")
	{
		if(strlen($attr)>0)
		if($attr[strlen($attr)-1]=="/") $this->have_close = True;
		$this->tag = $tag;
		$this->attr = $attr;
	}
	public function mPrint()
	{
		echo "<".$this->tag.$this->attr.">";
	}

	public function Parse($html,$current = 0)
	{
		return [$this->tag,True,$current];
	}
}
?>