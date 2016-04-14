<?php

namespace Models;

class Movies
{
	public  function __construct()
	{ 

	}

	public static function get_db()
	{
		include "../config/config.php";
		return new \PDO("mysql:dbname=".$configs['db_name'].";host=".$configs['host'] ,  $configs['username'] , $configs['password']);
	}


	public static function get_top()
	{
		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM MOVIE_DB ORDER BY rating DESC LIMIT 10");
		$statement->bindValue(":username" , $username);
		$statement->bindValue(":passhash" , $passhash);

		$statement->execute();

		$row = $statement->fetch(\PDO::FETCH_ASSOC);
		$top = array();
		while($row = $statement->fetch(\PDO::FETCH_ASSOC))
		{
			$top[] =  $row;
		}

		return $top;
	}

}