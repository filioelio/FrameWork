<?php namespace App\Controller;

	use App\Core\ControladorBase;
	
	class IndexController extends ControladorBase
	{
		
		/*		INDEX 		*/
		
		public function index()
		{
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error" //exito error
			);
			$this->view('Index', $data);
		}
		
		/*	**	*/
	}