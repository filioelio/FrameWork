<?php namespace App\Model;

	use App\Model\Clase\Personal as CPersonal;
	use App\Model\Action\Personal as APersonal;
	use App\Model\Clase\Eventos as CEventos;
	use App\Model\Action\Eventos as AEventos;
	use App\Model\Clase\Permiso as CPermiso;
	use App\Model\Action\Permiso as APermiso;
	use App\Model\Clase\Salario as CSalario;
	use App\Model\Action\Salario as ASalario;

	class PersonalModel
	{
		const PERSONAL_NAMESPACE = 'App\Model\Clase\Personal';
		const EVENTOS_NAMESPACE = 'App\Model\Clase\Eventos';
		const PERMISO_NAMESPACE = 'App\Model\Clase\Permiso';
		const SALARIO_NAMESPACE = 'App\Model\Clase\Salario';

		public function __construct()
		{}

		public function AllPersonal()
		{
			$a_personal = new APersonal();
			$personal = $a_personal->getAll(self::PERSONAL_NAMESPACE);
			if (! isset($personal)) return null;
			return $personal;

		}

		public function getByPersonal($id_personal)
		{
			$a_personal = new APersonal();
			$personal = $a_personal->getBy('id_personal', $id_personal, self::PERSONAL_NAMESPACE);
			if (! isset($personal)) return null;
			return $personal;
		}

		public function allEvento()
		{
			$a_evento = new AEventos();
			$eventos = $a_evento->allEvento();
			return $eventos;
		}

		public function allPermiso()
		{
			$a_permiso = new APermiso();
			$permiso = $a_permiso->allPermiso();
			return $permiso;
		}

		public function allSalario()
		{
			$a_salario = new ASalario();
			$salario = $a_salario->allSalario();
			return $salario;
		}

		public function SavePersonal($id_personal, $nombre, $apellido, $telefono, $direccion, $fecha_inicio, $labor, $salario, $estado, $id_usuario)
		{
			$a_personal = new APersonal();
			$c_personal = new CPersonal();

			$c_personal->setIdPersonal($id_personal);
			$c_personal->setNombre($nombre);
			$c_personal->setApellido($apellido);
			$c_personal->setTelefono($telefono);
			$c_personal->setDireccion($direccion);
			$c_personal->setFechaInicio($fecha_inicio);
			$c_personal->setLabor($labor);
			$c_personal->setSalario($salario);
			$c_personal->setEstado($estado);
			$c_personal->setFkIdUsuario($id_usuario);

			$personal = $a_personal->save($c_personal);
			return $personal;
		}

		public function SaveEventos($title, $start, $end, $background, $dato ,$user)
		{
			$a_evento = new AEventos();
			$c_evento = new CEventos();

			$c_evento->setTitle($title);
			$c_evento->setStart($start);
			$c_evento->setEnd($end);
			$c_evento->setBackground($background);
			$c_evento->setDatos($dato);
			$c_evento->setFkIdUsuario($user);

			$eventos = $a_evento->save($c_evento);
			return $eventos;
		}

		public function SavePermiso($fecha, $fecha_inicio, $fecha_fin, $descripcion, $color, $id_personal)
		{
			$a_permiso = new APermiso();
			$c_permiso = new CPermiso();

			$c_permiso->setFecha($fecha);
			$c_permiso->setFechaInicio($fecha_inicio);
			$c_permiso->setFechaFin($fecha_fin);
			$c_permiso->setDescripcion($descripcion);
			$c_permiso->setColor($color);
			$c_permiso->setFkIdPersonal($id_personal);

			$permiso = $a_permiso->save($c_permiso);
			return $permiso;
		}

		public function SaveSalario($fecha, $monto, $tipo, $color, $id_personal)
		{
			$a_salario = new ASalario();
			$c_salario = new CSalario();

			$c_salario->setFecha($fecha);
			$c_salario->setMonto($monto);
			$c_salario->setTipo($tipo);
			$c_salario->setColor($color);
			$c_salario->setFkIdPersonal($id_personal);

			$salario = $a_salario->save($c_salario);
			return $salario;
		}

		public function UpdatePersonal($id_personal, $nombre, $apellido, $telefono, $direccion, $fecha_inicio, $labor, $salario, $estado, $id_usuario)
		{
			$a_personal = new APersonal();
			$c_personal = new CPersonal();

			$c_personal->setIdPersonal($id_personal);
			$c_personal->setNombre($nombre);
			$c_personal->setApellido($apellido);
			$c_personal->setTelefono($telefono);
			$c_personal->setDireccion($direccion);
			$c_personal->setFechaInicio($fecha_inicio);
			$c_personal->setLabor($labor);
			$c_personal->setSalario($salario);
			$c_personal->setEstado($estado);
			$c_personal->setFkIdUsuario($id_usuario);

			$personal = $a_personal->update($c_personal);
			return $personal;
		}

		public function UpdateAsistencia($id_asistencia, $fecha, $estado, $descripcion, $id_personal)
		{
			$a_asistencia = new AAsistencia();
			$c_asistencia = new CAsistencia();

			$c_asistencia->setIdAsistencia($id_asistencia);
			$c_asistencia->setFecha($fecha);
			$c_asistencia->setEstado($estado);
			$c_asistencia->setDescripcion($descripcion);
			$c_asistencia->setFkIdPersonal($id_personal);

			$asistencia = $a_asistencia->update($c_asistencia);
			return $asistencia;
		}

		public function UpdatePermiso($id_permiso, $fecha_inicio, $fecha_fin)
		{
			$a_permiso = new APermiso();
			$c_permiso = new CPermiso();

			$c_permiso->setIdPermiso($id_permiso);
			$c_permiso->setFechaInicio($fecha_inicio);
			$c_permiso->setFechaFin($fecha_fin);

			$permiso = $a_permiso->update($c_permiso);
			return $permiso;
		}

		public function UpdateSalario($id_salario, $fecha)
		{
			$a_salario = new ASalario();
			$c_salario = new CSalario();

			$c_salario->setIdSalario($id_salario);
			$c_salario->setFecha($fecha);

			$salario = $a_salario->update($c_salario);
			return $salario;
		}



	}