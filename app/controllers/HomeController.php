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
				$recommended_movies = Movies::get_recommended_movies($_SESSION["username"]);
				$new_releases = Movies::get_new_releases();
				$condition = Movies::is_valid($_SESSION["username"]);
				$condition = intval($condition);
				if($condition==0)
					$val = 0;
				else
					$val = 2;
				$count = Movies::get_rating_count($_SESSION["username"]);
				$count = intval($count);
				if($count>=5)
					$val++;
				echo $this->twig->render("home.html" , array(
				"top" => $top,
				"reco"=> $recommended_movies,
				"condition"=>$val,
				"new"=> $new_releases));
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
			{
				echo $this->twig->render("index.html" , array(
				"title" => "Bioskop",
				"msg"=>"Invalid userame or password"));
			}
		}
		else if(isset($_POST["sign_up"]))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			// $sex = $_POST['sex'];
			$age = $_POST['age'];
			$occu = $_POST['occu'];
			$valid = Users::insert_user($username, $password,$age, $occu);

			if($valid==2)
			{
				echo "User already exists!";
			}
			else if($valid==1)
			{
				echo "Success!";
				header("Location: /");
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
