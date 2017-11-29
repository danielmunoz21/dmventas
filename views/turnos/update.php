<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnos */

$this->title = 'Update Dm Venta Turnos: ' . $model->dm_venta_turnos_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_venta_turnos_id, 'url' => ['view', 'id' => $model->dm_venta_turnos_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-venta-turnos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
