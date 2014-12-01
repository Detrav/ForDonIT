<?php
require_once(__dir__."/HTMRoot.php");
class HTMElement
{
	public $tag = NULL;
	public $attr = NULL;
	public $content = array();


	public function __construct($tag = "Unknown",$attr = "")
	{
		$this->tag = $tag;
		$this->attr = $attr;
	}

	//print html, return bool
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
		foreach ($this->content as $val) {
			if(is_string($val)) 
				echo $val;
			else
				$val->mPrint();
		}
		echo "</".$this->tag.">";
	}
	public function PrintTags($tags)
	{
		if(isset($tags[$this->tag]))
			$tags[$this->tag] +=1;
		else
			$tags[$this->tag] = 1;
		foreach ($this->content as $val) {
			if(!is_string($val)) 
				$tags = $val->PrintTags($tags);
		}
		return $tags;
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
								else//Если закрывается неизвестный тег
								{
									if($tag != "noindex")
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
		if($html[$current]=="!" && $html[$current+1] == "-" && $html[$current+2]=="-")
			return $this->GetTagComment($html,$current);
		for($current;$current<strlen($html);$current++ )
		{
			if($html[$current]==">")
				return [$tag,$close,$current];
			$tag .=$html[$current];
		}
		return [$tag,$close,$current];
	}

	protected function GetTagComment($html,$current)
	{
		$tag = "";
		for($current;$current<strlen($html);$current++ )
		{
			if($html[$current-2]=="-" && $html[$current-1]=="-")
			{
				if($html[$current] == ">")
				{
					return [$tag,False,$current];
				}
			}
			
			$tag.=$html[$current];
		}
		return [$tag,False,$current];
	}
}
?>