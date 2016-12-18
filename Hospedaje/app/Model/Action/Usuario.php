<?php namespace App\Model\Action;
	
	use App\Model\Clase\Usuario as CUsuario;
	use App\Core\ModeloBase;


	class Usuario extends ModeloBase
	{

		public function __construct()
		{
			$table = "usuario";
			parent::__construct($table);
		}

		public function Contar()
		{
			$run = $this->runSql(
				"SELECT count(*) as cantidad FROM usuario"
				);
			return $run;
		}


		public function save(CUsuario $usuario)
		{
			$foto = ($usuario->getFoto() == NULL) ? "NULL" : "'" . $usuario->getFoto() . "'";
			$save = $this->runSql(
				"INSERT INTO usuario (
					id_usuario,
					email,
					nombre,
					apellido,
					telefono,
					contrasena,
					foto,
					tipo,
					estado
				) VALUES (
					'" . $usuario->getIdUsuario() . "',
					'" . $usuario->getEmail() . "',
					'" . $usuario->getNombre() . "',
					'" . $usuario->getApellido() . "',	
					'" . $usuario->getTelefono() . "',				
					'" . $usuario->getContrasena() . "',
					$foto,
					'" . $usuario->getTipo() . "',
					'" . $usuario->getEstado() . "'
				)"
			);

			return $save;
		}

		public function update(CUsuario $usuario)
		{
			$foto = ($usuario->getFoto() == NULL) ? "NULL" : "'" . $usuario->getFoto() . "'";
			$update = $this->runSql(
				"UPDATE usuario SET 
				id_usuario = '" . $usuario->getIdUsuario() . "',
				email = '" . $usuario->getEmail() . "',
				nombre = '" . $usuario->getNombre() . "',
				apellido = '" . $usuario->getApellido() . "',
				telefono = '" . $usuario->getTelefono() . "',
				contrasena = '" . $usuario->getContrasena() . "',
				foto = $foto,
				tipo = '" . $usuario->getTipo() . "',
				estado = '" . $usuario->getEstado() . "' 
				WHERE id_usuario = '" . $usuario->getIdUsuario() . "'"
			);

			return $update;
		}

		public function delete(CUsuario $usuario)
		{
			$delete = $this->deleteId($usuario->getIdUsuario());

			return $delete;
		}

	}