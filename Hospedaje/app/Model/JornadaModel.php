<?php namespace App\Model;

	use App\Model\Clase\Jornada as CJornada;
	use App\Model\Action\Jornada as AJornada;

	/**
	* 
	*/
	class JornadaModel 
	{
		const JORNADA_NAMESPACE = 'App\Model\Clase\Jornada';

		public function __construct()
		{}

		public static function getIdLast()
		{
			$a_jornada = new AJornada();
			$IdJornada = $a_jornada->getIdLast(self::JORNADA_NAMESPACE);
			if (!isset($IdJornada)) return NULL; 
			return $IdJornada;
		}

		public function save($id_usuario)
		{
			$a_jornada = new AJornada();
			$c_jornada = new CJornada();

			$c_jornada->setFechaIngreso("");
			$c_jornada->setMonto("");
			$c_jornada->setFkIdUsuario($id_usuario);

			$jornada = $a_jornada->save($c_jornada);

			return $jornada;
		}

		public function update($id_usuario, $monto)
		{
			$IdJornada = self::getIdLast();
			if (!isset($IdJornada)) return false;
			$id = $IdJornada[0];
			
			if ($id->getFkIdUsuario() == $id_usuario) {
				$a_jornada = new AJornada();
				$c_jornada = new CJornada();

				$c_jornada->setIdJornada($id->getIdJornada());
				$c_jornada->setFechaSalida("");
				$c_jornada->setMonto($monto);
				$c_jornada->setFkIdUsuario($id_usuario);

				$jornada = $a_jornada->update($c_jornada);

				return $jornada;
			}

			return false;
		}
	}