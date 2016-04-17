<?php

namespace Controllers;
use Models\Users;
use Models\Movies;
class MovieController
{
	protected $twig;

	
	public function __construct()
	{
		$loader =  new \Twig_Loader_Filesystem(__DIR__ . '/../views');
		$this->twig = new \Twig_Environment($loader);
	}
	public function get($id)
	{
		session_start();
		if(isset($_SESSION["username"]))
		{
			$info = Movies::get_info($id);
			$genre = explode("|", $info["genre"]);
			$similar_movies = Movies::get_similar_movies($id);
			$rated = Movies::is_rated($_SESSION["username"], $id);
			if($rated)
				$my_rate = Movies::get_rating($_SESSION["username"], $id);
			echo $this->twig->render("movie.html" , array(
				"info" => $info,
				"title"=> $info["movie"],
				"genre"=> $genre,
				"similar"=>$similar_movies,
				"rated"=>$rated,
				"my_rate"=>$my_rate));
		}
		else
		{
			echo $this->twig->render("index.html" , array(
				"title" => "Bioskop"));
		}
	}
	public function post($movie)
	{
		session_start();
		if(isset($_SESSION["username"]))
		{
			if($_POST["rate"])
			{
				$info = Movies::get_info($movie);
				$val = Movies::update_logs($_SESSION["username"], $movie, $_POST["rating"]);
				if($val==1)
				{
					$msg = "Succesfully rated!";
					$rated = true;
				}
				else
				{
					$msg = "Rating failed!";
					$rated = false;
				}
				$similar_movies = Movies::get_similar_movies($movie);
				echo $this->twig->render("movie.html" , array(
					"info" => $info,
					"title"=> $info["movie"],
					"genre"=> $genre,
					"similar"=>$similar_movies,
					"rated"=>$rated,
					"my_rate"=>$_POST["rating"]));
			}
		}
		else
		{
			echo $this->twig->render("index.html" , array(
				"title" => "Bioskop"));
		}
	}
}
	
?>