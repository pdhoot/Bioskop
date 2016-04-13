<?php

namespace Controllers;
use Models\Users;
use Models\Movies;
class HomeController
{
	protected $twig;

	
	public function __construct()
	{
		$loader =  new \Twig_Loader_Filesystem(__DIR__ . '/../views');
		$this->twig = new \Twig_Environment($loader);
	}
	public function get()
	{
		echo $this->twig->render("index.html" , array(
				"title" => "Bioskop"));
	}
	public function post()
	{  
		if(isset($_POST['login']))
		{
			$x = Movies::getDB();   
			$username=$_POST['username'];
			$password=$_POST['password'];
			$valid=Users::checkLogin($username,$password);
			if($valid)
			{
			   echo "correct usr";
				
			}
			else 
				echo "sryyy";
		}
		/*if(isset($_POST['sign_up']))
		{
			   
		   $username=$_POST['username'];
		   $password=$_POST['password'];
		   $done=Users::addUser($username,$password);
		   if($done)
		   {
				echo "User added";
		   }
			else echo "some error is there";
		}
		if(isset['getTop'])
		{
		   $list=Movies::getTop();
		   if(!empty($list))
			 {
			 
			 }
			 else echo "error";
		}
		if(isset['getR'])
		{
		  $list=Movies::getRecommended();
		   if(!empty($list))
			 {
			 
			 }
			 else echo "error";
		}*/
	}
}
	
?>