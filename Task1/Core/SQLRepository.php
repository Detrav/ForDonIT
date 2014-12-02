<?php
/**
*  
*/
class SQLRepository
{
	static protected $HostName = "192.168.1.25";
	static protected $DataBaseName = "Ezepchuk_Task_1";
	static protected $UserName = "root";
	static protected $UserPass = "root";

	protected $mysql = NULL;

	function __construct()
	{

	}

	protected function GetSQL()
	{
		if(is_null($this->mysql))
			$this->mysql= new mysqli($this::$HostName,$this::$UserName,$this::$UserPass,$this::$DataBaseName);
		return $this->mysql;
	}

	public function Init()
	{
		$mysqli = new mysqli($this::$HostName,$this::$UserName,$this::$UserPass);
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$this::$DataBaseName." CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$mysqli->close();
		$query1 = <<< FILMS
CREATE TABLE
IF NOT EXISTS
films (
Id int NOT NUll AUTO_INCREMENT,
Name varchar(100) NOT NUll,
PRIMARY KEY (Id)
)
FILMS;
		$query2 = <<< ACTOR
CREATE TABLE
IF NOT EXISTS
actors (
Id int NOT NUll AUTO_INCREMENT,
Name varchar(100) NOT NUll,
PRIMARY KEY (Id)
)
ACTOR;
		$query3 = <<< CONNECTOR
CREATE TABLE
IF NOT EXISTS
connectors (
Id int NOT NUll AUTO_INCREMENT,
Film_Id int NOT NUll,
Actor_Id int NOT NUll,
PRIMARY KEY (Id)
)
CONNECTOR;
		
		$this->GetSQL()->query($query1);
		$this->GetSQL()->query($query2);
		$this->GetSQL()->query($query3);
		$this->FirstCreate();
	}

	public function FirstCreate()
	{
		$NeedToAdd = True;
		if ($stmt = $this->GetSQL()->prepare("SELECT * FROM films")) {
			$stmt->execute();
			$stmt->bind_result($id,$name);
			while ($stmt->fetch()) {

				$NeedToAdd = False;
			}
		$stmt->close();
		}

		if(!$NeedToAdd) return False;

		require_once("Arrays.php");

		foreach (Arrays::$films as $val) {
		$this->GetSQL()->query("INSERT INTO `films`(`Id`, `Name`) VALUES (NULL,'".$val."');");
		}
		foreach (Arrays::$actors as $val) {
		$this->GetSQL()->query("INSERT INTO `actors`(`Id`, `Name`) VALUES (NULL,'".$val."');");
		}

		for($i1=1;$i1<=55;$i1++)
		{
			$keys = array_rand(Arrays::$actors,rand( 1 , 7 ));
			if(is_array($keys))
				foreach($keys as $val)
				{
					$this->GetSQL()->query("INSERT INTO `connectors` (`Id`, `Actor_Id`,`Film_Id`) VALUES (NULL,'".(intval($val)+1)."','".$i1."');");
				}
			else
				$this->GetSQL()->query("INSERT INTO `connectors` (`Id`, `Actor_Id`,`Film_Id`) VALUES (NULL,'".(intval($keys)+1)."','".$i1."');");
		}
	}

	public function GetFilms()
	{
		require_once(__DIR__."/../Models/Film.php");
		$films = array();
		if ($stmt = $this->GetSQL()->prepare("SELECT films.Id, films.Name FROM films")) 
		{
			$stmt->execute();
			$stmt->bind_result($FId,$Name);
			while ($stmt->fetch()) 
			{
			$films[] = new Film($FId,$Name);
			}
			$stmt->close();
			return $films;
		}
		return False;
	}

	public function GetFilm($Id)
	{
		require_once(__DIR__."/../Models/Actor.php");
		require_once(__DIR__."/../Models/Film.php");
		$query = <<<MYQUERY
SELECT films.Id, films.Name, actors.id, actors.Name
FROM films, connectors,actors
WHERE films.Id = ?
AND	connectors.Film_Id = films.Id
And actors.Id = connectors.Actor_Id;
MYQUERY;
		if ($stmt = $this->GetSQL()->prepare($query)) {
			$stmt->bind_param("i",$Id);
			$stmt->execute();
			$stmt->bind_result($FId,$Name,$Actor_Id,$Actor_Name);
			$film = NULL;
			while ($stmt->fetch()) {
				if(is_null($film))
				{
					$film = new Film($FId,$Name);
				}
				$film->AddActor(new Actor($Actor_Id,$Actor_Name));
			}
		$stmt->close();
		if(is_null($film))
		{
			$query = <<<MYQUERY
SELECT films.Id, films.Name
FROM films
WHERE films.Id = ?;
MYQUERY;
			if ($stmt = $this->GetSQL()->prepare($query)) {
				$stmt->bind_param("i",$Id);
				$stmt->execute();
				$stmt->bind_result($FId,$Name);
				if ($stmt->fetch()) 
					$film = new Film($FId,$Name);
				$stmt->close();
				return $film;
			}
		}
		foreach ($film->Actors as $value) {
			$value->CountFilm = $this->GetCountActor($value->Id);
		}
		return $film;
		}
		return "False";
	}

	public function GetCountActor($Id)
	{
		$query = <<<MYQUERY
SELECT COUNT(*)
FROM films, connectors
WHERE connectors.Actor_Id = ?
And films.Id = connectors.Film_Id;
MYQUERY;
		if ($stmt = $this->GetSQL()->prepare($query)) {
			$stmt->bind_param("i",$Id);
			$stmt->execute();
			$stmt->bind_result($Count);
			if($stmt->fetch())
				return $Count;
			$stmt->close();
			}
		return 0;
	}


}
?>