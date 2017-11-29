<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentas */

$this->title = $model->dm_venta_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-ventas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dm_venta_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dm_venta_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dm_venta_id',
            'dm_cajas_dm_cajas_id',
            'dm_usuario_dm_usuario_id',
            'dm_venta_cantidad',
            'dm_venta_turnos_dm_venta_turnos_id',
            'dm_productos_dm_id_producto',
        ],
    ]) ?>

</div>
