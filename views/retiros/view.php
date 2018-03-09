<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaRetiros */

$this->title = $model->retiro_id;
$this->params['breadcrumbs'][] = ['label' => 'Retiros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$aCajas = app\models\DmCajas::getAll();
$aUsuarios = app\models\DmUsuario::getAll();
$aTurnos = app\models\DmVentaTurnos::getAll();


?>
<div class="dm-venta-retiros-view">

    <p>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->retiro_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar este retiro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'retiro_id',
            'retiro_monto',
            'retiro_datetime',
            [
                'attribute' => 'dm_cajas_dm_cajas_id',
                'value' => $aCajas[$model->dm_cajas_dm_cajas_id],
            ],
            [
                'attribute' => 'dm_usuario_dm_usuario_id',
                'value' => $aUsuarios[$model->dm_usuario_dm_usuario_id],
            ],
            [
                'attribute' => 'dm_venta_turnos_dm_venta_turnos_id',
                'value' => $aTurnos[$model->dm_venta_turnos_dm_venta_turnos_id],
            ],
        ],
    ]) ?>

</div>
