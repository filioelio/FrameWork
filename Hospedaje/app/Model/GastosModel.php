<?php namespace App\Model;

	use App\Model\Clase\Gasto as CGastos;
	use App\Model\Action\Gasto as AGastos;
	use App\Model\Clase\Usuario as CUsuario;
	use App\Model\Action\Usuario as AUsuario;

	class GastosModel
	{
		const GASTOS_NAMESPACE = 'App\Model\Clase\Gasto';
		const USUARIO_NAMESPACE = 'App\Model\Clase\Usuario';

		public function __construct()
		{}

		public function all()
		{
			$a_gastos = new AGastos();
			$a_usuario = new AUsuario();
			$gasto = $a_gastos->getAll(self::GASTOS_NAMESPACE);
			if (!isset($gasto)) return NULL;
			foreach ($gasto as $index => $user_actual) 
			{
				$usuario = $a_usuario->getBy('id_usuario',$user_actual->getFkIdUsuario(), self::USUARIO_NAMESPACE)[0];
				if (!isset($usuario)) continue;
				$user_actual->setPerfilUsuario($usuario);
				$gasto [$index] = $user_actual;
			}

			return $gasto;
		}

		public function getId($id)
		{
			$a_gastos = new AGastos();
			$gasto = $a_gastos->getById($id, self::GASTOS_NAMESPACE);
			if (!isset($gasto)) return NULL;
			return $gasto;
		}

		public function allFecha($fecha)
		{
			$a_gastos = new AGastos();
			$a_usuario = new AUsuario();
			$gasto = $a_gastos->getlIKE('fecha', $fecha, self::GASTOS_NAMESPACE);
			if (!isset($gasto)) return NULL;
			foreach ($gasto as $index => $user_actual) 
			{
				$usuario = $a_usuario->getBy('id_usuario',$user_actual->getFkIdUsuario(), self::USUARIO_NAMESPACE)[0];
				if (!isset($usuario)) continue;
				$user_actual->setPerfilUsuario($usuario);
				$gasto [$index] = $user_actual;
			}

			return $gasto;
		}

		public function allMajorDate($fecha)
		{
			$a_gastos = new AGastos();
			$a_usuario = new AUsuario();
			$gasto = $a_gastos->getMajorDate('fecha', $fecha, self::GASTOS_NAMESPACE);
			if (!isset($gasto)) return NULL;
			foreach ($gasto as $index => $user_actual) 
			{
				$usuario = $a_usuario->getBy('id_usuario',$user_actual->getFkIdUsuario(), self::USUARIO_NAMESPACE)[0];
				if (!isset($usuario)) continue;
				$user_actual->setPerfilUsuario($usuario);
				$gasto [$index] = $user_actual;
			}

			return $gasto;
		}

		public function save($recibe, $fecha, $monto, $descripcion, $id_usuario)
		{
			$a_gastos = new AGastos();
			$c_gastos = new CGastos();

			$c_gastos->setRecibe($recibe);
			$c_gastos->setFecha($fecha);
			$c_gastos->setMonto($monto);
			$c_gastos->setDescripcion($descripcion);
			$c_gastos->setFkIdUsuario($id_usuario);

			$gastos = $a_gastos->save($c_gastos);
			return $gastos; 
		}

		public function update($id_gasto, $recibe, $monto, $descripcion, $id_usuario)
		{
			$a_gastos = new AGastos();
			$c_gastos = new CGastos();

			$c_gastos->setIdGasto($id_gasto);
			$c_gastos->setRecibe($recibe);
			$c_gastos->setMonto($monto);
			$c_gastos->setDescripcion($descripcion);
			$c_gastos->setFkIdUsuario($id_usuario);

			$gastos = $a_gastos->update($c_gastos);
			return $gastos; 
		}
	}