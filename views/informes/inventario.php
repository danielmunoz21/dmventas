<?php
/**
 * File to Inventario
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

$this->title = 'Inventario';
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Informes';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['informes/inventario']];

?>
<h1>Inventario</h1>

<?php
$aGridColumns = [
	['class' => 'kartik\grid\SerialColumn'],

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
];

echo ExportMenu::widget([
	'dataProvider' => $dataProvider,
	'columns' => $aGridColumns,
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_CSV => false,
    ]
]);
?>

<?php Pjax::begin(); ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $aGridColumns,
    ]); ?>
<?php Pjax::end(); ?></div>