<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DmVentaTurnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-turnos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registrar Turno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'dm_venta_turnos_id',
            'dm_nombre',
            'dm_venta_hora_inicio',
            'dm_venta_hora_termino',
            'dm_venta_turno_orden',
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'dm_venta_cierre_sig_dia',
                'value' => function( $data ){
                    $aOpciones = app\models\DmVentaTurnos::opciones();
                    return $aOpciones[ $data['dm_venta_cierre_sig_dia'] ];
                  },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => app\models\DmVentaTurnos::opciones(),
                    'options' => [
                      'placeholder' => 'Seleccione',
                    ],
                ]

            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
