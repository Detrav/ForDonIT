<html>
<head></head>
<body>
<?php
require(__DIR__."/Core/MySort.php");
$test_array = array();
$val = 0;
for($i = 0;$i<20;$i++)
{
	$val += rand(1,3);
	$test_array[] = $val;
}
$test_array2 = $test_array;
shuffle($test_array);
$a2=array_flip($test_array);			$key2=array_keys($a2);
$a3=MySort::keysort($a2);		$key3=array_keys($a3);
echo "<table border =\"1\"><tr><td>Несорт ключи</td><td>Несорт знач</td><td>Cорт ключи</td><td>Cорт знач</td></tr>";
for($i=0;$i<20;$i++)
{
echo "<tr><td>".$key2[$i]."</td><td>".$a2[$key2[$i]]."</td><td>".$key3[$i]."</td><td>".$a3[$key3[$i]]."</td></tr>";	
}
echo "</table>";
?>
</body>
</html>