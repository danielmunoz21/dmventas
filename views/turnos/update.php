<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnos */

$this->title = 'Actualizar turno: ' . $model->dm_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_nombre, 'url' => ['view', 'id' => $model->dm_venta_turnos_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="dm-venta-turnos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
