<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?=$titulo_view?></title>
	<?=$helper->css('pdf');?>
</head>
<body>
	<section class="ed-container">
		<div class="ed-container">
			<header class="header_container">
				<img src="<?=$helper->img_url().'\bannerweb.jpg'?>" alt="">
			</header>
				<?php if(isset($reporte) && $reporte != 1):?>
					<div class="ed-item">
						<h2 class="titulo__tabla"><?=$titulo_page?></h2>
					</div>
					<div class="ed-item">					
						<table class="reporte__tabla">
							<thead>
								<tr class="tabla__titulos">
							    	<?php foreach($cabezeras as $cabezera): ?>
							    		<th><?=$cabezera?></th>
									<?php endforeach; ?>
							    </tr>
							</thead>
							<tbody>
								<?php if ($reporte != 1): ?>
									<?php foreach($reporte as $item_reporte): ?>
								    	<tr class="tabla__items">
								      		<?php foreach($cabezeras as $cabezera): ?>
								      			<?php if ($cabezera == 'fecha' || $cabezera == 'fecha_ingreso' || $cabezera == 'fecha_salida'): ?>
								      				<td><?=$helper->FormatDateTime($item_reporte->$cabezera)?></td>
								      			<?php else: ?>
								      				<td><?=$item_reporte->$cabezera?></td>
								      			<?php endif ?>
									    		
											<?php endforeach; ?>
								    	</tr>
									<?php endforeach; ?>
									<tr class="tabla__total tabla__items">
										<td>TOTAL</td>
										<td colspan="<?=$colspan?>"><?=$reporte[0]->total?></td>
										<?php if (isset($reporte[0]->ingresoneto)): ?>
											<td colspan="2" >INGRESO NETO</td>
											<td colspan="3"><?=$reporte[0]->ingresoneto?></td>
										<?php endif ?>
									</tr>
								<?php endif ?>
							</tbody>
						</table> 
					</div>
				</div>
			<?php endif; ?>
			<?php if(isset($ventas) && $ventas != 1):?>
				<div class="ed-container">
					<div class="ed-item">
						<h2 class="titulo__tabla">Reporte de Ventas del <?=$titulo_pages?></h2>
					</div>
					<div class="ed-item">					
						<table class="reporte__tabla">
							<thead>
								<tr class="tabla__titulos">
							    	<?php foreach($cabezeras_venta as $cabezera): ?>
							    		<th><?=$cabezera?></th>
									<?php endforeach; ?>
							    </tr>
							</thead>
							<tbody>
								<?php if ($ventas != 1): ?>
									<?php foreach($ventas as $item_reporte): ?>
								    	<tr class="tabla__items">
								      		<?php foreach($cabezeras_venta as $cabezera): ?>
								      			<?php if ($cabezera == 'fecha'): ?>
								      				<td><?=$helper->FormatDateTime($item_reporte->$cabezera)?></td>
								      			<?php else: ?>
								      				<td><?=$item_reporte->$cabezera?></td>
								      			<?php endif ?>
									    		
											<?php endforeach; ?>
								    	</tr>
									<?php endforeach; ?>
									<tr class="tabla__total tabla__items">
										<td>TOTAL</td>
										<td colspan="2"><?=$ventas[0]->total?></td>
										<td colspan="2" >INGRESO NETO</td>
										<td colspan="3"><?=$ventas[0]->ingresoneto?></td>
									</tr>
								<?php endif ?>
							</tbody>
						</table> 
					</div>
				</div>
			<?php endif; ?>
			<?php if(isset($reservaciones) && $reservaciones != 1):?>
				<div class="ed-container">
					<div class="ed-item">
						<h2 class="titulo__tabla">Reporte de reservaciones del <?=$titulo_pages?></h2>
					</div>
					<div class="ed-item">					
						<table class="reporte__tabla">
							<thead>
								<tr class="tabla__titulos">
							    	<?php foreach($cabezeras_reser as $cabezera): ?>
							    		<th><?=$cabezera?></th>
									<?php endforeach; ?>
							    </tr>
							</thead>
							<tbody>
								<?php if ($reservaciones != 1): ?>
									<?php foreach($reservaciones as $item): ?>
								    	<tr class="tabla__items">
								      		<?php foreach($cabezeras_reser as $cabezera): ?>
								      			<?php if ($cabezera == 'fecha_reser'): ?>
								      				<td><?=$helper->FormatDateTime($item->$cabezera)?></td>
								      			<?php else: ?>
								      				<td><?=$item->$cabezera?></td>
								      			<?php endif ?>
									    		
											<?php endforeach; ?>
								    	</tr>
									<?php endforeach; ?>
									<tr class="tabla__total tabla__items">
										<td>TOTAL</td>
										<td colspan="6"><?=$reservaciones[0]->total?></td>
									</tr>
								<?php endif ?>
							</tbody>
						</table> 
					</div>
				</div>
			<?php endif; ?>
			<?php if(isset($gastos)):?>
				<div class="ed-container">
					<div class="ed-item">
						<h2 class="titulo__tabla">Reporte de Gastos del <?=$titulo_pages?></h2>
					</div>
					<div class="ed-item">					
						<table class="reporte__tabla">
							<thead>
								<tr class="tabla__titulos">
							    	<?php foreach($cabezeras_gasto as $cabezera): ?>
							    		<th><?=$cabezera?></th>
									<?php endforeach; ?>
							    </tr>
							</thead>
							<tbody>
								<?php foreach ($gastos as $key => $item): ?>
				                	<tr class="tabla__items">
					                	<td><?=$item->getIdGasto()?></td>
					                	<td><?=$item->getRecibe()?></td>
					                	<td><?=$item->getMonto()?></td>
					                	<td><?=$item->getDescripcion()?></td>
					                	<td><?=$helper->FormatDateTime($item->getFecha())?></td>
					                	<td><?=$item->getPerfilUsuario()->getNombre()?></td>
					                </tr>
				                <?php endforeach ?>
				                <tr class="tabla__total tabla__items">
									<td colspan="2">TOTAL</td>
									<td colspan="4"><?= $gatostoday?></td>
								</tr>
							</tbody>
						</table> 
					</div>
				</div>
			<?php endif ?>
			<?php if (isset($reportetodaycompleto)): ?>
					<div class="ed-container">
						<div class="ed-item">
							<h2 class="titulo__tabla">RESUMEN</h2>
						</div>
						<div class="ed-item">					
							<table class="reporte__tabla">
								<thead class="tabla__titulos">
									<tr>
										<th>TIPO DE INGRESO</th>
										<th>SUB-TOTAL</th>
									</tr>
								</thead>
								<tbody>
									<tr class="tabla__items">
										<td>Hospedaje</td>
										<td><?= isset($reporte) && $reporte!=1? $reporte[0]->total : 0?></td>
									</tr>
									<tr class="tabla__items">
										<td>Ventas</td>
										<td><?= isset($ventas) && $ventas!=1? $ventas[0]->ingresoneto : 0 ?></td>
									</tr>
									<tr class="tabla__items">
										<td>Reservaciones</td>
										<td><?= isset($reservaciones) && $reservaciones!=1? $reservaciones[0]->total : 0?></td>
									</tr>
									<tr class="tabla__items">
										<td>Gastos</td>
										<td><?= $gatostoday?></td>
									</tr>

									<tr class="tabla__total tabla__items">
										<td>TOTAL</td>
										<td ><?=(isset($reporte) && $reporte!=1? $reporte[0]->total : 0)+(isset($ventas) && $ventas!=1? $ventas[0]->ingresoneto : 0 )+(isset($reservaciones)  && $reservaciones!=1? $reservaciones[0]->total : 0)-($gatostoday)?></td>
									</tr>
								</tbody>
							</table> 
						</div>
					</div>
			<?php endif; ?>
	</section>
	
</body>
</html>