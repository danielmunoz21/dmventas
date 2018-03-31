<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Registro de Ventas';
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Informes';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="dm-productos-bajostock">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
		'filterRowOptions' => ['class' => 'kartik-sheet-style'],

		'columns' => [
			['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute'=>'dm_venta_datetime',
                'options' => [
                    'format' => 'YYYY-MM-DD',
                ],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'dm_venta_datetime',
                    'presetDropdown' => true,
                    'convertFormat' => false,
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'format' => 'YYYY-MM-DD',
                        'locale' => [
                            'format' => 'YYYY-MM-DD'
                        ],
                    ],
                    'pluginEvents' => [
                        "apply.daterangepicker" => "function() { apply_filter('dm_venta_datetime') }",
                    ],
                ])
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'dm_usuario_dm_usuario_id',
                'value' => function( $data ){
                    $aUsuarios = app\models\DmUsuario::getAll();
                    return $aUsuarios[ $data['dm_usuario_dm_usuario_id'] ];
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => app\models\DmUsuario::getAll(),
                    'options' => [
                        'placeholder' => 'Seleccione Usuario',
                    ],
                ]

            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'dm_venta_turno_id',
                'value' => function( $data ){
                    $aTurnos = app\models\DmVentaTurnos::getAll();
                    return $aTurnos[ $data['dm_venta_turno_id'] ];
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => app\models\DmVentaTurnos::getAll(),
                    'options' => [
                        'placeholder' => 'Seleccione  turno',
                    ],
                ]

            ],
            'dm_venta_total',
			[
			    'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                        'view' => function($url, $model){
	                        $url = 'view/'. $model->dm_venta_diario_id;
	                        return Html::a(
		                        '<span class="glyphicon glyphicon-eye-open"></span>',
		                        $url,
		                        [
			                        'title' => 'View',
			                        //'data-pjax' => '0',
		                        ]
	                        );
                        }
                ]
            ],
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>