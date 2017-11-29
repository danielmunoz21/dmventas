<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaDiario */

$this->title = $model->dm_venta_diario_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-diario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dm_venta_diario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dm_venta_diario_id], [
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
            'dm_venta_diario_id',
            'dm_venta_total',
            'dm_venta_datetime',
            'dm_usuario_dm_usuario_id',
        ],
    ]) ?>

</div>
