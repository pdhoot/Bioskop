<?php

namespace Models;

class Users
{   private $conn;
	public  function __construct()
	{ 
          //echo "jidl";
	}
	public static function checkLogin($username,$password)
	{  
	    if($username=='888' && $password=='999')
	      return true;
	      else return false;
	}
	public function addUser($username,$password)
	{
	    return true;
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

}