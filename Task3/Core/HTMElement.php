<?php
require_once(__dir__."/HTMRoot.php");
class HTMElement
{
	public $tag = NULL;
	public $attr = NULL;
	public $content = array();


	public function __construct($tag = "Unknown")
	{
		$this->tag = $tag;
	}

	//print html, return bool
	public function mPrint()
	{
		echo "<".$this->tag." ".$this->attr.">";
		foreach ($this->content as $val) {
			if(is_string($val)) 
				echo $val;
			else
				$val->mPrint();
		}
		echo "</".$this->tag.">";
	}
	//return array(tag,close,cur)
	public function Parse($html,$current = 0)
	{
		//проверка если тег закрылся
		if($html[$current]==">") $current++;
		$text = "";
		for($current;$current<strlen($html);$current++ )
		{
			switch ($html[$current]) 
			{
				case '<'://Нашли начало тега
					$this->content[] = $text; $text = "";
					$arr = $this->GetTagName($html,$current+1);
					if($arr)//Получилось прочитать тег
					{
						
						list($tag, $close, $current) = $arr;
						if($close)//Тег закрывабщися
						{
							//Если закрывается текущий тег
							if($tag == $this->tag)
							{
								return [$tag,True, $current];
							}
							else//Если закрывается не известный тег
							{
								return [$tag,False, $current];
							}
						}
						$el = HTMRoot::CreateElement($tag);
						$current = $el->ParseTagAttr($html,$current);
						//парсим значения на новом теге
						$arr = $el->Parse($html,$current);
						//добавляем елемент в список
						$this->content[] = $el;
						//получен конец тега, что дальше?
						if($arr)
						{
							list($tag,$close,$current) = $arr;
							if($close)
							{

							}
							else
							{
								//Если закрывается текущий тег
								if($tag == $this->tag)
								{
									return [$tag,True,$current];
								}
								else//Если закрывается не известный тег
								{
									return [$tag,False,$current];
								}
							}
						}
					}
					break;
				default:
					$text.=$html[$current];
					break;
			}
		}
	}
	//return array(tag,close,cur)
	protected function GetTagName($html,$current)
	{
		$tag = "";
		$close = False;
		if($html[$current]=="/") { $close = True; $current++; }
		for($current;$current<strlen($html);$current++ )
		{
			if($html[$current]==" " || $html[$current]==">")
				return [$tag,$close,$current];
			$tag .=$html[$current];
		}
		return [$tag,$close,$current];
	}
	//return array(attr,cur)
	protected function ParseTagAttr($html,$current)
	{
		$this->attr = "";
		for($current;$current<strlen($html);$current++ )
		{
			if($html[$current]==">")
				return  $current;
			$this->attr .= $html[$current];
		}
		return $current;
	}
}
?>