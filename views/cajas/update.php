<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmCajas */

$this->title = 'Actualizar caja: ' . $model->dm_cajas_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_cajas_nombre, 'url' => ['view', 'id' => $model->dm_cajas_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-cajas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
