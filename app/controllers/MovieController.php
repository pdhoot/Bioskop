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
			echo $this->twig->render("movie.html" , array(
				"info" => $info,
				"title"=> $info["movie"],
				"genre"=> $genre));
		}
		else
		{
			echo $this->twig->render("index.html" , array(
				"title" => "Bioskop"));
		}
	}
	public function post()
	{  
		
	}
}
	
?>