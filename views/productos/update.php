<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmProductos */

$this->title = 'Actualizar Producto: ' . $model->dm_nom_producto;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_nom_producto, 'url' => ['view', 'id' => $model->dm_id_producto]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="dm-productos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aCajas' => $aCajas,
    ]) ?>

</div>
