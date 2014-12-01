<?php
require_once(__dir__."/HTMVoid.php");
class HTMComment extends HTMVoid
{
	public function mPrint()
	{
		
	}

	protected function ParseTagAttr($html,$current)
	{
		
		$this->attr = "";
		for($current;$current<strlen($html);$current++ )
		{
			if($html[$current]=="-")
				if($html[$current+1]=="-")
					if($html[$current+2]==">")
				return  $current+2;
			//$this->attr .= $html[$current];
		}
		return $current;
	}
}
?>