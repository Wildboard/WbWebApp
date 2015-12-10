<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Getapp extends Controller
{
	
	public function action_index()
	{
	   $ua = $_SERVER['HTTP_USER_AGENT'];
	   echo("Coming soon for $ua!");
	   die();	
    
 	}

}
