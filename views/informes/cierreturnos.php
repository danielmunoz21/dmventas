<?php
/**
 * File to cierre de turnos
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Cierre de turnos';
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Informes';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['informes/cierreturnos']];


?>

<div class="dm-cierre-turnos">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'kartik\grid\SerialColumn'],
			//'dm_apert_monto',
            [
                'attribute'=>'dm_apert_fecha',
                'options' => [
                    'format' => 'YYYY-MM-DD',
                ],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'dm_apert_fecha',
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
				'attribute' => 'dm_usuario_id',
				'value' => function( $data ){
					$aUser = app\models\DmUsuario::getAll();
					return $aUser[ $data['dm_usuario_id'] ];
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
				'attribute' => 'dm_turnos_id',
				'value' => function( $data ){
					$aTurn = app\models\DmVentaTurnos::getAll();
					if ( !isset( $data['dm_turnos_id'] ) && empty( $data['dm_turnos_id'] ) ) {
					    return '-';
                    }
                    else {
	                    return $aTurn[ $data['dm_turnos_id'] ];
                    }
				},
				'filterType' => GridView::FILTER_SELECT2,
				'filterWidgetOptions' => [
					'data' => app\models\DmVentaTurnos::getAll(),
					'options' => [
						'placeholder' => 'Seleccione Turno',
					],
				]

			],
			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{cierre}',
				'buttons' => [
					'cierre' => function ($url) {
						return Html::a(
							'<span class="glyphicon glyphicon-floppy-save"></span>',
							$url,
							[
								'title' => 'Ver detalle pdf',
								//'data-pjax' => '0',
							]
						);
					},
				],
			],
		],
	]); ?>
	<?php Pjax::end(); ?></div>

</div>
