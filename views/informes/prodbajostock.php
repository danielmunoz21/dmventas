<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DmProdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventario productos bajo Stock';
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Informes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-productos-bajostock">

	<h1><?= Html::encode($this->title) ?></h1>

    <p>
			<?php
			echo Html::a( '<i class="fa glyphicon glyphicon-download-alt"></i> Generar Listado Imprimible', [ '/informes/prodbajostockpdf' ], [
				'class'       => 'btn btn-info',
				'target'      => '_blank',
				'data-toggle' => 'tooltip',
				'title'       => 'Genera PDF con listado de productos bajo stock'
			] );
			?>
    </p>
	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
				'autoXlFormat'=>true,
				'export'=>[
					'fontAwesome'=>true,
					'showConfirmAlert'=>false,
					'target'=>GridView::TARGET_BLANK
				],
		'columns' => [
			//['class' => 'kartik\grid\SerialColumn'],

			//'dm_id_producto',
			'dm_codigo',
			'dm_nom_producto',
			//'dm_stock_min_compras',
			'dm_stock',
			'dm_precio_compra',
			'dm_porcentaje_ganancia',
			'dm_precio_venta',
			[
				'class' => '\kartik\grid\DataColumn',
				'attribute' => 'dm_cajas_id',
				'value' => function( $data ){
					$aCajas = app\models\DmCajas::getAll();
					return $aCajas[ $data['dm_cajas_id'] ];
				},
				'filterType' => GridView::FILTER_SELECT2,
				'filterWidgetOptions' => [
					'data' => app\models\DmCajas::getAll(),
					'options' => [
						'placeholder' => 'Seleccione Caja',
					],
				]

			],
			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{stock} {view} {update} {delete}',
				'buttons' => [
					'stock' => function ($url) {
						return Html::a(
							'<span class="glyphicon glyphicon-plus-sign"></span>',
							$url,
							[
								'title' => 'Agregar Stock',
								//'data-pjax' => '0',
							]
						);
					},
				],
                'urlCreator' => function( $action, $model, $key, $index ){

	                $url = '';

	                if ($action === 'view') {
	                    $url = Url::to(['/productos/view', 'id' => $model->dm_id_producto]);
		                return $url;
	                }

	                if ($action === 'update') {
		                $url = Url::to(['/productos/update', 'id' => $model->dm_id_producto]);
		                return $url;
	                }
	                if ($action === 'delete') {
		                $url = Url::to(['/productos/delete', 'id' => $model->dm_id_producto]);
		                return $url;
	                }
	                if ($action === 'stock') {
		                $url = Url::to(['/productos/stock', 'id' => $model->dm_id_producto]);
		                return $url;
	                }

                    return $url;
                }
			],
		],
	]); ?>
	<?php Pjax::end(); ?></div>
