<?php namespace App\Helpers;
	
	class Security 
	{
		/*		CLEAN INPUT 		*/
		
		public static function clean_input ($data) 
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			
			return $data;
		}
		
		/*	**	*/
	}

/*		FIN CLASS HELPERS SECURITY		*/