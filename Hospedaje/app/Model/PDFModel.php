<?php namespace App\Model;

	use Dompdf\Dompdf;
	use Autoloader;

	class PDFModel 
	{

		protected static $configured = false;

		public static function configure()
		{

			if(static::$configured) return ;

			require_once '../vendor/dompdf/autoload.inc.php';

			static::$configured = true;

		}

		public static function generar($file, $html)
		{
			static::configure();
			$dompdf = new Dompdf();

			$dompdf->loadhtml($html);
			// $dompdf->setPaper('A4', 'landscape');
			$dompdf->render();
			$dompdf->stream($file);

		}

	}