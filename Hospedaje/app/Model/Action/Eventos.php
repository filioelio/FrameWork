<?php namespace app\Model\Action;
	
	use App\Model\Clase\Eventos as CEventos;
	use App\Core\ModeloBase;


	class Eventos extends ModeloBase
	{

		public function __construct()
		{
			$table = "eventos";
			parent::__construct($table);
		}

		public function allEvento()
		{
			$run = $this->runSql("SELECT id_eventos, concat(title,' : ',datos) as title, estart as start, ennd as end, background as backgroundColor, datos FROM eventos");
			return $run;
		}

		public function save(CEventos $evento)
		{
			$save = $this->runSql(
				"INSERT INTO `eventos`
				(
					`id_eventos`, 
					`title`, 
					`estart`, 
					`ennd`, 
					`background`, 
					`datos`, 
					`fk_id_usuario`

				) VALUES (
					'" . $evento->getIdEvento()."',
					'" . $evento->getTitle()."',
					'" . $evento->getStart()."',
					'" . $evento->getEnd()."',
					'" . $evento->getBackground()."',			
					'" . $evento->getDatos() . "',
					'" . $evento->getFkIdUsuario()."'
				)"
			);

			return $save;
		}

		public function update(CEventos $evento)
		{
			$update = $this->runSql(
				"UPDATE evento SET 
				id_evento 		= '" . $evento->getIdEvento() . "',
				fecha 				= '" . $evento->getFecha() . "',
				estado	 			= '" . $evento->getEstado() . "',
				descripcion			= '" . $evento->getDescripcion() . "',	
				fk_id_personal		= '" . $evento->getFkIdPersonal() . "'
				WHERE id_evento = '" . $evento->getIdEvento() . "'"
			);

			return $update;
		}

		public function delete(CEventos $evento)
		{
			$delete = $this->deleteby("id_evento",$evento->getIdAsistencia());

			return $delete;
		}

	}