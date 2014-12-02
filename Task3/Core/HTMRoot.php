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

	public function PrintTags($tags)
	{
		foreach ($this->content as $val) {
			if(!is_string($val)) 
				$tags = $val->PrintTags($tags);
		}
		return $tags;
	}

	static public function CreateElement($tag)
	{
		$name = "";
		$attr = "";
		$i = 0;
		for($i;$i<strlen($tag);$i++)
		{
			if($tag[$i]==" " || $tag[$i]=="\n" || ($i>0 ? $tag[$i]=="/" : False))
			{
				for($i;$i<strlen($tag);$i++)
				{
					$attr.=$tag[$i];
				}
			}
			else
			{
				$name .=$tag[$i];
			}
		}
		//echo "$name<br>";
		try { if($name[0]== "!" && $name[1]== "-" && $name[2]== "-"){ return new HTMComment($name,$attr);} }
		catch(Exception $e) { }

		require_once(__dir__."/HTMElement.php");
		require_once(__dir__."/HTMComment.php");
		require_once(__dir__."/HTMNormal.php");
		require_once(__dir__."/HTMScript.php");
		require_once(__dir__."/HTMVoid.php");
		switch (strtolower($name)) {
			case 'script':
					return new HTMScript(strtolower($name),$attr);
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
			case '!doctype':
					return new HTMVoid(strtolower($name),$attr);
				break;
			default:
					return new HTMNormal(strtolower($name),$attr);
				break;
		}
	}
}
?>


