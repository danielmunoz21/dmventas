<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaDiario */

$this->title = 'Update Dm Venta Diario: ' . $model->dm_venta_diario_id;
$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_venta_diario_id, 'url' => ['view', 'id' => $model->dm_venta_diario_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-venta-diario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
