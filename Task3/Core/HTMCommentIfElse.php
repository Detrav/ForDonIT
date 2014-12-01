<?php
require_once(__dir__."/HTMComment.php");
class HTMCommentIfElse extends HTMComment
{
	protected function ParseTagAttr($html,$current)
	{
		$this->attr = "";
/*		for($current;$current<strlen($html);$current++ )
		{
			
//			echo $current."<br>";
			echo (strpos($html,"endif]-->",$current) !=$current)."<br>";
			if(strpos($html,"endif]-->",$current) === $current);
			{
				return  $current+8;
			}
			//$this->attr .= $html[$current];

		}
		return $current;*/
		return strpos($html,"endif]-->",$current)+8;
	}
}
?>