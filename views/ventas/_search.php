<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-ventas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dm_venta_id') ?>

    <?= $form->field($model, 'dm_cajas_dm_cajas_id') ?>

    <?= $form->field($model, 'dm_usuario_dm_usuario_id') ?>

    <?= $form->field($model, 'dm_venta_cantidad') ?>

    <?= $form->field($model, 'dm_venta_turnos_dm_venta_turnos_id') ?>

    <?php // echo $form->field($model, 'dm_productos_dm_id_producto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
