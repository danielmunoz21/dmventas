<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DmVentaRetirosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de retiros registrados en el sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-retiros-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'retiro_id',
            'retiro_monto',
            'retiro_datetime:datetime',
	        [
		        'class' => '\kartik\grid\DataColumn',
		        'attribute' => 'dm_cajas_dm_cajas_id',
		        'value' => function( $data ){
			        $aCajas = app\models\DmCajas::getAll();
			        return $aCajas[ $data['dm_cajas_dm_cajas_id'] ];
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
				        'placeholder' => 'Seleccione  usuario',
			        ],
		        ]

	        ],
	        [
		        'class' => '\kartik\grid\DataColumn',
		        'attribute' => 'dm_venta_turnos_dm_venta_turnos_id',
		        'value' => function( $data ){
			        $aTurnos = app\models\DmVentaTurnos::getAll();
			        return $aTurnos[ $data['dm_venta_turnos_dm_venta_turnos_id'] ];
		        },
		        'filterType' => GridView::FILTER_SELECT2,
		        'filterWidgetOptions' => [
			        'data' => app\models\DmVentaTurnos::getAll(),
			        'options' => [
				        'placeholder' => 'Seleccione  turno',
			        ],
		        ]

	        ],

	        [
		        'class' => 'kartik\grid\ActionColumn',
		        'template' => '{view} {delete}',
	        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
