<?php namespace App\Controller;

	use App\Core\ControladorBase;
	
	class IndexController extends ControladorBase
	{
		
		/*		INDEX 		*/
		
		public function index()
		{
			$this->view('Index');
		}
		
		/*	**	*/
	}