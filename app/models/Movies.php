<?php

namespace Models;

class Movies
{   private $con;
	public  function __construct()
	{ 
	}
	public static function getDB()
	{
		include "../config/config.php";
		var_dump($configs);
		return new \PDO("mysql:dbname=".$configs['db_name'].";host=".$configs['host'] ,  $configs['username'] , $configs['password']);
	}
	
	public function getTop()
	{
	  if(conn())
	  {
        
	  }
	}
	public function getRecommended()
	{
	  if(conn)
	  {
        
	  }
	}
	public function getRecent()
	{
	  if(conn)
	  {
        
	  }
	}
	public function getResults()
	{
	  if(conn)
	  {
        
	  }
	}
	public function getTagResults()
	{
	  if(conn)
	  {
        
	  }
	}
}