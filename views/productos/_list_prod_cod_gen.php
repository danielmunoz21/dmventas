<?php
/**
 * Listado de productos con códigos generados
 */

use app\models\DmCajas;

?>
<h3>Listado productos código generado</h3>
<table class="table">
	<thead>
	<tr>
		<td>Código</td>
		<td>Producto</td>
		<td>Caja</td>
		<td>Código de barras</td>
	</tr>
	</thead>
	<tbody>
<?php

 foreach ( $aProd as $index => $oProd ){
		$oCaja = DmCajas::findOne( $oProd->dm_cajas_id );
	  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		echo '<tr>';
			echo '<td>'. $oProd->dm_codigo .'</td>';
			echo '<td>'. $oProd->dm_nom_producto.'</td>';
			echo '<td>'. $oCaja->dm_cajas_nombre .'</td>';
	 echo '<td><img src="data:image/png;base64,' . base64_encode($generator->getBarcode($oProd->dm_codigo, $generator::TYPE_CODE_128)) . '"></td>';
		echo '</tr>';
 }

?>
	</tbody>
</table>
