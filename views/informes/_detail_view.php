<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'DETALLE DE VENTA ' . $strFecha;
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Informes';
$this->params['breadcrumbs'][] = [ 'label' => 'Registro de Ventas', 'url' => ['ventasreg'] ];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="dm-detail-venta">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render( '_detail_venta', [ 'modelDiario' => $modelDiario, 'aUsuarios' => $aUsuarios, 'aTurnos' => $aTurnos ] ) ?>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'kartik\grid\SerialColumn'],

			//'dm_venta_id',
			'dm_venta_cantidad',
			//'dm_productos_dm_id_producto',
			//'dm_venta_diario_dm_venta_diario_id',

			[
				'class' => '\kartik\grid\DataColumn',
				'attribute' => 'dm_productos_dm_id_producto',
				'value' => function( $data ){
					$aProductos = app\models\DmProductos::getAllMap();
					return $aProductos[ $data['dm_productos_dm_id_producto'] ];
				},
				'filterType' => GridView::FILTER_SELECT2,
				'filterWidgetOptions' => [
					'data' => app\models\DmProductos::getAllMap(),
					'options' => [
						'placeholder' => 'Seleccione Producto',
					],
				]

			],
		],
	]); ?>



</div>