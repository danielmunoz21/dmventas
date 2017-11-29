<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentas */

$this->title = 'Update Dm Ventas: ' . $model->dm_venta_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_venta_id, 'url' => ['view', 'id' => $model->dm_venta_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-ventas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
