<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaApertura */

$this->title = $model->dm_apert_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Aperturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-apertura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dm_apert_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dm_apert_id], [
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
            'dm_apert_id',
            'dm_apert_monto',
            'dm_apert_fecha',
            'dm_usuario_id',
        ],
    ]) ?>

</div>
