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

		$statement = $db->prepare("SELECT * FROM MOVIE_DB ORDER BY rating DESC LIMIT 9");

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
	public function get_result($query,$tag)
	{
		$db = self::get_db();
        $query="%".$query."%";
        if($tag)
        {
        $statement = $db->prepare("SELECT * FROM MOVIE_DB WHERE genre Like :movie");
        }
        else
        {
		$statement = $db->prepare("SELECT * FROM MOVIE_DB WHERE movie Like :movie");
	    }
		$statement->bindValue(":movie" , $query);

		$statement->execute();
          
		$result=array();
		while($row = $statement->fetch(\PDO::FETCH_ASSOC))
		{   
			$result[] =  $row;
		}

		return $result;		
	}

}