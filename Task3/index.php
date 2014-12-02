<html>
<head>
</head>
<body>
<?php

echo <<<FORM
<form method="POST">
<input size="100" type = "url" name = "myurl" placeholder="For site URL">
<input type = "submit" name = "submit" value = "Send">
</form>
FORM;

if(isset($_POST["submit"]))
{
	$html_test = file_get_contents($_POST["myurl"]);
	//echo $html_test;
	require_once(__dir__."/Core/HTMRoot.php");
	$root = new HTMRoot("document");
	$test = $root->Parse($html_test);
	//print_r($root);
//	$root->mPrint();
	$tags = array();
	$tags = $root->PrintTags($tags);
//	$
	ksort($tags);

echo <<<TABLE
<table border = "1">
	<tr>
		<td width ="100">Tag</td>
		<td width ="100">Open</td>
		<td width ="100">Close</td>
		<td width ="100">Extra</td>
	</tr>
TABLE;

foreach($tags as $key => $val)
{
echo "<tr><td>".$key."</td><td>".$val["open"]."</td><td>".$val["close"]."</td><td>".$val["extra"]."</td><tr>";
}

echo "</table>";
}

?>
</body>