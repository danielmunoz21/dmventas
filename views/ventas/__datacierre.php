<?php
use app\models\DmProductos;
use app\models\DmVentaRetiros;
$aResumen = array();
$iTotalRetiros = 0;
if ( count( $aCajas ) > 0 ){
    
	foreach( $aCajas as $oModelCaja ){

		$iTotalCantidad = 0;
		$iTotalVentas   = 0;
		$iMonto = DmVentaRetiros::getMountbyData( $user->id, $user->id_turno, $oModelCaja->dm_cajas_id, $strFecha );
        $iTotalRetiros += $iMonto;
		?>

		<div class="panel panel-default">
			<div class="panel-heading"><?php echo $oModelCaja->dm_cajas_nombre; ?></div>
			<table class="table table-condensed">
				<thead>
				<tr>
					<td><strong>C&oacute;digo Producto</strong></td>
					<td><strong>Producto</strong></td>
					<td><strong>Valor/unidad</strong></td>
					<td><strong>Cantidad Vendida</strong></td>
					<td><strong>Cantidad Restante</strong></td>
					<td><strong>Total</strong></td>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($aCierres as $key => $data) {

					if ( $data['cajaid'] == $oModelCaja->dm_cajas_id ){
						$modelProd = DmProductos::findOne( $data['prodid'] );
						$iTotalVprod = $data['total'] * $data['cantidad'];
						$iTotalCantidad += $data['cantidad'];
						$iTotalVentas   += $iTotalVprod;

						$strTotal = number_format( $iTotalVprod, 0, ',' , '.' );
						$strTotalProd = number_format( $data['prodprecio'], 0, ',', '.' );
                        $decimals = mb_substr( $data['cantidad'], mb_strpos( $data['cantidad'], '.' ) + 1, mb_strlen( $data['cantidad'] ) );
						if ( $decimals > 0 ) {
						    $cantidadvend = number_format( $data['cantidad'], 3, ',', '.' );
                        }
                        else {
						    $cantidadvend = $data['cantidad'];
                        }

						echo '<tr>';

						echo '<td>'. $data['prodcod'] .'</td>';
						echo '<td>'. $data['nomprod'] .'</td>';
						echo '<td>$'. $strTotalProd .'</td>';
						echo '<td>'. $cantidadvend .'</td>';
						echo '<td>'.$modelProd->dm_stock.'</td>';
						echo '<td>$'. $strTotal .'</td>';
						echo '</tr>';

						unset( $aCierres[ $key ] );


					}
				}
				$aResumen[ $oModelCaja->dm_cajas_id ]['nombre'] = $oModelCaja->dm_cajas_nombre;
				$aResumen[ $oModelCaja->dm_cajas_id ]['total'] = $iTotalVentas;
				?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="4"><strong>TOTAL EN VENTAS</strong></td>
					<td>&nbsp;</td>
					<td><strong><?php echo '$'. number_format( $iTotalVentas, 0, ',' , '.' ); ?></strong></td>
				</tr>
                <tr>
                    <td colspan="4"><strong>TOTAL DE RETIROS</strong></td>
                    <td>&nbsp;</td>
                    <td><strong><?php echo '$'. number_format( $iMonto, 0, ',' , '.' ); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>SALDO EN CAJA</strong></td>
                    <td>&nbsp;</td>
                    <td><strong><?php echo '$'. number_format( ( $iTotalVentas - $iMonto ), 0, ',' , '.' ); ?></strong></td>
                </tr>
				</tfoot>
			</table>
		</div>

		<?php

	}
	?>
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="title">Resumen de cajas</h3></div>
		<table class="table table-condensed">
			<thead>
			<tr>
				<td><strong>Caja</strong></td>
				<td><strong>Total</strong></td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>Monto apertura de caja</td>
				<td>$<?php echo number_format( $iMontoApertura, 0, ',', '.' ) ?></td>
			</tr>
			<?php
			$iTotal = $iMontoApertura;
			foreach ($aResumen as $iIdCaja => $data){
				$iTotal += $data['total'];
				$strTotal  = number_format( $data['total'], 0, ',', '.' );
				echo '<tr>';
				echo '<td>'. $data['nombre'] .'</td>';
				echo '<td>$'. $strTotal .'</td>';
				echo '</tr>';
			}
			$iTotal = $iTotal - $iTotalRetiros;
			?>
            <tr>
                <td>TOTAL DE RETIROS</td>
                <td>$<?php echo number_format( $iTotalRetiros, 0, ',', '.' ) ?></td>
            </tr>
			</tbody>
			<tfoot>
			<tr>
				<td><strong>SALDO TOTAL EN CAJA</strong></td>
				<td><strong>$<?php echo number_format( $iTotal, 0, ',', '.' ); ?></strong></td>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php


}




?>