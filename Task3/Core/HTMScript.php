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
								return [$tag,True,$current];
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
}
?>