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
}