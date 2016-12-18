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
		
		/*	**	*/

		public static function sesion_iniciada($controller, $uri1 = "index", $uri2 = "index")
		{
			if(isset($_SESSION['user']['email']) && isset($_SESSION['user']['contrasena']))
			{
				$controller->redirect($uri1, $uri2);
			}
		}

		public static function sesion_iniciada_inactivo($controller, $url1 = "index", $url2 = "logout")
		{
			if (!isset($_SESSION['user']['email']) || !isset($_SESSION['user']['contrasena']) || !isset($_SESSION['user']['estado']) || $_SESSION['user']['estado'] != 'Activo') {
				$controller->redirect($url1, $url2);
			}
		}

		public static function sesion_no_iniciada($controller, $uri1 = "index", $uri2 = "index")
		{
			if(! isset($_SESSION['user']['email']) || ! isset($_SESSION['user']['contrasena']))
			{
				$controller->redirect($uri1, $uri2);
			}
		}

		public static function session_no_iniciada_administrador($controller, $uri1 = "index", $uri2 = "index")
		{
			if(! isset($_SESSION['user']['email']) || ! isset($_SESSION['user']['contrasena']) || ! isset($_SESSION['user']['tipo']) || $_SESSION['user']['tipo'] != "Admin")
			{
				$controller->redirect($uri1, $uri2);
			}
		}

	}

/*		FIN CLASS HELPERS SECURITY		*/