<?php
require_once(__dir__."/HTMNormal.php");
class HTMScript extends HTMNormal
{
	public function Parse($html,$current = 0)
	{
		if($html[$current]==">") $current++;
		$text = "";
		for($current;$current<strlen($html);$current++ )
		{
			switch ($html[$current]) 
			{
				case '<'://Нашли начало тега
					$arr = $this->GetTagName($html,$current+1);
					if($arr)//Получилось прочитать тег
					{
						list($tag, $close, $current) = $arr;
						if($close)//Тег закрывабщися
						{
							//Если закрывается текущий тег
							if($tag == $this->tag)
							{
								$this->content[] = $text;
								$this->have_close = True;
								return [$tag,True,$current];
							}
						}
					}
				default:
					$text.=$html[$current];
					break;
			}
		}
	}
	protected function GetTagName($html,$current)
	{
		$tag = "";
		$close = False;
		$tmp = $current;
		if($html[$tmp]=="/") { $close = True; $tmp++; }
		for ($tmp; $tmp < $current+7; $tmp++) { 
			$tag.=$html[$tmp];
		}
		if($tag == $this->tag)
			return [$tag,$close,$tmp];

		return [$tag,False,$current-1];
	}
}
?>