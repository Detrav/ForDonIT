<?php

class MySort
{
	static public function keysort($array)
	{
		$keys = array_keys($array);
		$newkeys = self::fast_sort($keys,0,count($keys)-1);
		foreach ($newkeys as $val) {
			$newarray[$val] = $array[$val];
		}
		return $newarray;
	}
	static public function fast_sort($array,$min,$max)
	{
		//print_r($array); echo "<br>";
		$l = $min;
		$r = $max;
		$m = $array[(int)(($min+$max) / 2)];
		do {
			while ($array[$l] < $m) { $l++; }
			while ($array[$r] > $m) { $r--; }
			if($l<=$r)
			{
				$tmp = $array[$l];
				$array[$l]=$array[$r];
				$array[$r]=$tmp;
				$l++; $r--;
			}
		} while ( $l<$r);
		if ($min<$r)
		{
			$array = self::fast_sort($array,$min,$r);
		}
		if ($l<$max)
		{
			$array = self::fast_sort($array,$l,$max);
		}
		return $array;
	}
}
?>