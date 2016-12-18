<?php namespace App\Model;

	use App\Model\Clase\Usuario as CUsuario;
	use App\Model\Action\Usuario as AUsuario;

	class UsuarioModel
	{

		const USUARIO_NAMESPACE = 'App\Model\Clase\Usuario';

		public function __construct()
		{}

		public function contar()
		{
			$a_user = new AUsuario();
			$contar = $a_user->Contar();

			if(isset($contar) && (is_array($contar) || is_object($contar)))
			{
				if(is_object($contar))
				{
					$contar = array($contar);
				}
				$contar = $contar;
			}
			return $contar;
		}

		public function all()
		{
			$a_user = new AUsuario();
			$usuarios = $a_user->getAll(self::USUARIO_NAMESPACE);
			if (! isset($usuarios)) return null;
			return $usuarios;

		}
		public function getBy($id)
		{
			$a_usuario = new AUsuario();
			$usuario = $a_usuario->getBy("id_usuario", $id, self::USUARIO_NAMESPACE);
			if (! isset($usuario)) return NULL;
			return $usuario;
		}

		public static function getEmail($email)
		{
			$a_usuario = new AUsuario();
			$usuario = $a_usuario->getBy("email", $email, self::USUARIO_NAMESPACE);
			if (! isset($usuario)) return NULL;
			return $usuario;
		}


		public static function login($email, $contrasena)
		{
			$user = self::getEmail($email);
			
			if (!isset($user)) return false;

			$user = $user[0];
			
			if ($user->getContrasena() == md5($contrasena))
			{
				@session_start();
				$_SESSION['user']['email']	= $user->getEmail();
				$_SESSION['user']['contrasena'] = $user->getContrasena();
				$_SESSION['user']['tipo'] = $user->getTipo();
				$_SESSION['user']['estado'] = $user->getEstado();
				return true;
			}

			return false;
		}
				
		public static function logout()
		{
			@session_start();
			unset($_SESSION['user']);
		}

		public static function save($dni, $email, $nombre, $apellido, $telefono, $contrasena, $foto, $tipo, $estado)
		{
			$c_usuario = new CUsuario();
			$a_usuario = new AUsuario();

			$c_usuario->setIdUsuario($dni);
			$c_usuario->setEmail($email);
			$c_usuario->setNombre($nombre);
			$c_usuario->setApellido($apellido);
			$c_usuario->setTelefono($telefono);
			$c_usuario->setContrasena(md5($contrasena));
			$c_usuario->setFoto($foto);
			$c_usuario->setTipo($tipo);
			$c_usuario->setEstado($estado);

			$update_user = $a_usuario->save($c_usuario);
			
			return $update_user;
		}

		public static function update($dni, $email, $nombre, $apellido, $telefono, $contrasena, $foto, $tipo, $estado)
		{
			$c_usuario = new CUsuario();
			$a_usuario = new AUsuario();

			$usuario_existe = self::getEmail($email);
			if (! isset($usuario_existe)) return false;

			$c_usuario->setIdUsuario($dni);
			$c_usuario->setEmail($email);
			$c_usuario->setNombre($nombre);
			$c_usuario->setApellido($apellido);
			$c_usuario->setTelefono($telefono);
			$c_usuario->setContrasena(md5($contrasena));
			$c_usuario->setFoto($foto);
			$c_usuario->setTipo($tipo);
			$c_usuario->setEstado($estado);

			$update_user = $a_usuario->update($c_usuario);

			return $update_user;
		}

		public static function updateadmin($dni, $email, $nombre, $apellido, $telefono, $contrasena, $foto, $tipo, $estado)
		{
			$c_usuario = new CUsuario();
			$a_usuario = new AUsuario();

			$usuario_existe = self::getEmail($email);
			if (! isset($usuario_existe)) return false;

			$c_usuario->setIdUsuario($dni);
			$c_usuario->setEmail($email);
			$c_usuario->setNombre($nombre);
			$c_usuario->setApellido($apellido);
			$c_usuario->setTelefono($telefono);
			$c_usuario->setContrasena($contrasena);
			$c_usuario->setFoto($foto);
			$c_usuario->setTipo($tipo);
			$c_usuario->setEstado($estado);

			$update_user = $a_usuario->update($c_usuario);

			return $update_user;
		}		
	}
