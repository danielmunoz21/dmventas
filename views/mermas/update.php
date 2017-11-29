<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmMermas */

$this->title = 'Actualizar merma ';
$this->params['breadcrumbs'][] = ['label' => 'Mermas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->merma_id, 'url' => ['view', 'id' => $model->merma_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dm-mermas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aProductos' => $aProductos,
        'aCajas' => $aCajas,
    ]) ?>

</div>
