<?php

namespace Models;

class Users
{ 

	public  function __construct()
	{ 

	}

	public static function get_db()
	{
		include "../config/config.php";
		return new \PDO("mysql:dbname=".$configs['db_name'].";host=".$configs['host'] ,  $configs['username'] , $configs['password']);
	}

	public static function check_login($username, $password)
	{
		$db = self::get_db();

		$passhash = md5($password);

		$statement = $db->prepare("SELECT * FROM USER_DB WHERE username = :username AND password = :password");
		$statement->bindValue(":username" , $username);
		$statement->bindValue(":password" , $passhash);

		$statement->execute();

		$row = $statement->fetch(\PDO::FETCH_ASSOC);
		if($row)
		{
			return true;
		}	
		else
		{
			return false;
		}

	}

	public static function insert_user($username, $password, $sex='M', $age=0, $occu=1)
	{
		$db = self::get_db();

		$stat = $db->prepare("SELECT * FROM USER_DB WHERE username = :username");

		$stat->bindValue(":username" , $username);

		$stat->execute();

		$row = $stat->fetch(\PDO::FETCH_ASSOC);

		if($row)
		{
			return 2;
		}

		$passhash = md5($password);

		$statement = $db->prepare("INSERT INTO USER_DB (username , password  , gender , age, occu) VALUES (:username , :password  , :sex , :age, :occu)");

		$result = $statement->execute(array(
			"username"=>$username,
			"password"=>$passhash,
			"sex"=>$sex,
			"age"=>$age,
			"occu"=>$occu));
		if($result)
		{
			session_start();
			$_SESSION['username'] = $username;
			return 1;
		}
		else
		{
			return 0;
		}
	}

}