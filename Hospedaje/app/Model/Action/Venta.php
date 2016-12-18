<?php namespace app\Model\Action;
	
	use App\Model\Clase\Venta as CVenta;
	use App\Core\ModeloBase;


	class Venta extends ModeloBase
	{

		public function __construct()
		{
			$table = "venta";
			parent::__construct($table);
		}

		public function VentaHabitacionId($id_habitacion)
		{
			$run = $this->runProcedure("VentaHabitacionId($id_habitacion)");
			return $run;
		}

		public function deuda_venta($id)
		{
			$run = $this->runProcedure("DeudaHabitacionId($id)");
			return $run;
		}


		public function select_venta($id)
		{
			$run = $this->runProcedure("VentaSelectId($id)");
			return $run;
		}

		public function Ventas()
		{
			$run = $this->runProcedure("VentasAll");
			return $run;
		}

		public function max_id()
		{
			$run = $this->runSql("SELECT MAX(id_venta) AS id FROM venta");
			return $run;
		}

		public function save(CVenta $_venta)
		{
			$save = $this->runSql(
				"INSERT INTO venta (
					id_venta,
					total,
					fecha,
					deuda,
					fk_id_usuario,
					fk_id_hospedaje
	
				) VALUES (
					NULL,
					'" . $_venta->getTotal() . "',
					'" . $_venta->getFechaVenta() . "',
					'" . $_venta->getDeuda() . "',
					'" . $_venta->getFkIdUsuario() . "',			
					'" . $_venta->getFkIdHospedaje(). "'
				);"
			);
			return $save;
		}

		public function update(CVenta $_venta)
		{
			$update = $this->runSql(
				"UPDATE venta SET 
				deuda	 		= '" . $_venta->getDeuda() . "'
				WHERE id_venta 	= '" . $_venta->getIdVenta() . "'"
			);

			return $update;
		}

		public function delete(CVenta $_venta)
		{
			$delete = $this->deleteId($_venta->getIdVenta());

			return $delete;
		}

	}