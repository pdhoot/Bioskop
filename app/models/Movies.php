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

	public static function get_similar_movies($id)
	{
		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM SIM_DB WHERE id = :id");
		$statement->bindValue(":id" , $id);

		$statement->execute();

		$movies = $statement->fetch(\PDO::FETCH_ASSOC);
		
		$info = array();
		for($i=1; $i<=6 ; $i++)
		{
			$info[] = self::get_info($movies[$i]);
		}

		return $info;

	}

	public static function get_id($username)
	{
		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM USER_DB WHERE username=:username");
		$statement->bindValue(":username" , $username);

		$statement->execute();

		$info = $statement->fetch(\PDO::FETCH_ASSOC);

		return $info["id"];
	}

	public static function get_recommended_movies($username)
	{
		$id = self::get_id($username);

		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM RECO_DB WHERE id = :id");
		$statement->bindValue(":id" , $id);

		$statement->execute();

		$movies = $statement->fetch(\PDO::FETCH_ASSOC);
		
		$info = array();
		for($i=1; $i<=10 ; $i++)
		{
			$info[] = self::get_info($movies[strval($i)]);
		}

		return $info;
	}

	public static function is_rated($username, $movie)
	{
		$user = self::get_id($username);

		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM LOGS_DB WHERE user = :user AND movie = :movie");
		$statement->bindValue(":user" , $user);
		$statement->bindValue(":movie" , $movie);

		$statement->execute();

		$log = $statement->fetch(\PDO::FETCH_ASSOC);
		
		if($log)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public static function update_logs($username, $movie, $rating)
	{
		$update = self::is_rated($username, $movie);

		$db = self::get_db();

		$user = self::get_id($username);

		if($update)
		{
			$statement = $db->prepare("UPDATE LOGS_DB SET rating = :rating WHERE user=:user AND movie=:movie");
		}
		else
		{
			$statement = $db->prepare("INSERT INTO LOGS_DB(user, movie, rating) VALUES(:user, :movie, :rating)");
		}

		$result = $statement->execute(array(
			"user"=>$user,
			"movie"=>$movie,
			"rating"=>$rating));

		if($result)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public static function get_rating($username, $movie)
	{
		$update = self::is_rated($username, $movie);

		$db = self::get_db();

		$user = self::get_id($username);

		$statement = $db->prepare("SELECT * FROM LOGS_DB WHERE user = :user AND movie = :movie");
		$statement->bindValue(":user" , $user);
		$statement->bindValue(":movie" , $movie);

		$statement->execute();

		$log = $statement->fetch(\PDO::FETCH_ASSOC);
		
		return $log["rating"];
	}


	public static function get_rating_count($username)
	{
		$user = self::get_id($username);

		$db = self::get_db();

		$statement = $db->prepare("SELECT COUNT(*) AS cnt FROM LOGS_DB WHERE user = :user");
		$statement->bindValue(":user" , $user);

		$statement->execute();

		$log = $statement->fetch(\PDO::FETCH_ASSOC);
		
		return $log["cnt"];
	}

	public static function is_valid($username)
	{
		$user = self::get_id($username);

		$db = self::get_db();

		$statement = $db->prepare("SELECT valid FROM USER_DB WHERE id = :user");
		$statement->bindValue(":user" , $user);

		$statement->execute();

		$log = $statement->fetch(\PDO::FETCH_ASSOC);
		
		return $log["valid"];
	}

	public static function get_new_releases()
	{
		$db = self::get_db();

		$statement = $db->prepare("SELECT * FROM MOVIE_DB ORDER BY time DESC LIMIT 10");

		$statement->execute();
		
		$result=array();
		while($row = $statement->fetch(\PDO::FETCH_ASSOC))
		{
			$result[] =  $row;
		}

		return $result;
	}
}
