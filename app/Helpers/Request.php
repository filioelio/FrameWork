<?php namespace App\Helpers;

	class Request 
	{

		/*		FUNCTION IS AJAX 		*/
		
		public static function is_ajax() 
		{
		  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
		}
			
		/*	**	*/

		/*		VALID USUARIO TWITTER 		*/
		
		public static function valid_twitter_username($campo)
		{
			if(! preg_match('/^(\@)?[A-Za-z0-9_]+$/', $campo))
		    {
		        return false;
		    }
		    return true;
		}
		
		/*	**	*/

		/*		VALID USUARIO FACEBOOK 		*/
		
		public static function valid_facebook_username($campo)
		{
		    return self::valid_user_name($campo);
		}
		
		/*	**	*/

		/*		VALID USER NAME 		*/
		
		public static function valid_user_name($campo)
		{
			if(! preg_match('/^[A-Za-z0-9_]+$/', $campo))
		    {
		        return false;
		    }
		    return true;
		}
		
		/*	**	*/

	}

/*		FIN CLASS HELPER REQUEST		*/