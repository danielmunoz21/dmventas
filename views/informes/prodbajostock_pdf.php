<?php
/**
 *
 */

?>
<body>
<table class="table">
	<thead>
		<tr>
			<td>#</td>
			<td>Código</td>
			<td>Producto</td>
			<td>Stock</td>
			<td>Precio</td>
		</tr>
	</thead>
    <tbody>
<?php
	if ( $dataProvider != false ) {
		foreach( $dataProvider as $key => $data ){
			$model = (object) $data;
			 echo '<tr>';
			 echo '<td>'. ($key + 1) . '</td>';
			 echo '<td>'. $model->dm_codigo . '</td>';
			 echo '<td>'. $model->dm_nom_producto . '</td>';
			 echo '<td>'. $model->dm_stock . '</td>';
			 echo '<td>'. $model->dm_precio_venta . '</td>';
			 echo '</tr>';
		}
	}
	?>
    </tbody>
</table>
</body>


