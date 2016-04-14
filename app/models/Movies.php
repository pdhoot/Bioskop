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

		$top = array();
		while($row = $statement->fetch(\PDO::FETCH_ASSOC))
		{
			$top[] =  $row;
		}

		return $top;
	}

	public static function get_info($id)
	{
		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM MOVIE_DB WHERE id=:id");
		$statement->bindValue(":id" , $id);

		$statement->execute();

		$info = $statement->fetch(\PDO::FETCH_ASSOC);

		return $info;
	}

}