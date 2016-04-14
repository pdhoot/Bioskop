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
		session_start();
		if(isset($_SESSION["username"]))
		{   
			if(isset($_GET['get_result']))
			{
				$query=$_GET['query'];
				if($_GET['tag']==0)
					{
						$result=Movies::get_result($query,0);
						$title='All';
					}
			    else
			    	{
						$result=Movies::get_result($query,1);
						$title=$_GET['query'];						
			    	}
				echo $this->twig->render("result.html",array(
					"result"=>$result,
					"title"=>$title));
			}

			else
			{
				$top = Movies::get_top();
				echo $this->twig->render("home.html" , array(
				"top" => $top));
			}
		}
		else
		{
			echo $this->twig->render("index.html" , array(
				"title" => "Bioskop"));
		}

	}
	public function post()
	{
		error_log("asdf");

		if(isset($_POST['login']))
		{ 
			$username=$_POST['username'];
			$password=$_POST['password'];
			$valid=Users::check_login($username,$password);
			session_start();
			if($valid)
			{
				$_SESSION["username"] = $username;
				header("Location: /");
			}
			else 
				echo "sryyy";
		}
		else if(isset($_POST["sign_up"]))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			// $sex = $_POST['sex'];
			// $age = $_POST['age'];
			// $occu = $_POST['occu'];

			$valid = Users::insert_user($username, $password);

			if($valid==2)
			{
				echo "User already exists!";
			}
			else if($valid==1)
			{
				echo "Success!";
			}
			else
			{
				echo "Error!";
			}
		}
		else if(isset($_POST["logout"]))
		{
			session_start();
			session_unset();
			session_destroy();
			header("Location: /");
		}
	}
}
	
?>