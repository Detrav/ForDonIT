<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<?php
require(__DIR__."/Core/SQLRepository.php");
$db = new SQLRepository();
$res = $db->Init();


if(isset($_GET["Id"]))
{
$film = $db->GetFilm($_GET["Id"]);
echo "<h1>".$film->Name."</h1>";
echo "<br>";
echo "<b>Актёрский состав:</b>";
echo "<table border = \"1\"><tr><td>Актёр</td><td>Количество фильмов</td></tr>";
foreach($film->Actors as $val)
{
	echo "<tr><td>".$val->Name."</td><td>".$val->CountFilm."</td></tr>";
}
echo "</table>";
echo "<a href =\"/Task1/\">Назад</a>";
}
else
{
$films = $db->GetFilms();
echo "<table border = \"1\"><tr><td>Название</td><td>Ссылка</td></tr>";
foreach($films as $val)
{
	echo "<tr><td>".$val->Name."</td><td> <a href = \"?Id=".$val->Id."\">Перейти</a></td></tr>";
}
echo "</table>";
}
?>

</body>
</html>