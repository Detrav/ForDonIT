<?php
require_once(__dir__."/HTMElement.php");
class HTMRoot extends HTMElement
{

	public function mPrint()
	{
		foreach ($this->content as $val) {
			if(is_string($val)) 
				echo $val;
			else
				$val->mPrint();
		}
	}

	static public function CreateElement($tag)
	{
		require_once(__dir__."/HTMElement.php");
		require_once(__dir__."/HTMComment.php");
		require_once(__dir__."/HTMNormal.php");
		require_once(__dir__."/HTMScript.php");
		require_once(__dir__."/HTMVoid.php");
		require_once(__dir__."/HTMCommentIfElse.php");
		switch (strtolower($tag)) {
			case '!--':
					return new HTMComment($tag);
				break;
			case '!--[if':
					return new HTMCommentIfElse($tag);
				break;
			case 'script':
					return new HTMScript($tag);
				break;
			case 'area':
			case 'base':
			case 'br':
			case 'col':
			case 'command':
			case 'embed':
			case 'hr':
			case 'img':
			case 'input':
			case 'keygen':
			case 'link':
			case 'meta':
			case 'param':
			case 'source':
			case 'track':
			case 'wbr':
					return new HTMVoid($tag);
				break;
			default:
					return new HTMNormal($tag);
				break;
		}
	}
}
?>

