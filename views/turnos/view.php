<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnos */

$this->title = $model->dm_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-turnos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->dm_venta_turnos_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->dm_venta_turnos_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este turno?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'dm_venta_turnos_id',
            'dm_nombre',
            'dm_venta_turno_orden',
            [
                'attribute' => 'dm_venta_cierre_sig_dia',
                'value' => ( $model->dm_venta_cierre_sig_dia  == 1 ) ? 'Si' : 'No'
            ],
            [
                'attribute' => 'dm_venta_hora_inicio',
                'format' => 'raw',
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => 'kartik\widgets\TimePicker',
                    'pluginOptions' => [
                        'defaultTime' => false,
                    ]
                ],
            ],
            [
                'attribute' => 'dm_venta_hora_termino',
                'format' => 'raw',
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => 'kartik\widgets\TimePicker',
                    'pluginOptions' => [
                        'defaultTime' => false,
                    ]
                ],
            ],
        ],
    ]) ?>

</div>
