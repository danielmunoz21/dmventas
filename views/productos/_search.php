<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmProdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-productos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dm_id_producto') ?>

    <?= $form->field($model, 'dm_codigo') ?>

    <?= $form->field($model, 'dm_nom_producto') ?>

    <?= $form->field($model, 'dm_stock_min_compras') ?>

    <?= $form->field($model, 'dm_stock') ?>

    <?php // echo $form->field($model, 'dm_precio_compra') ?>

    <?php // echo $form->field($model, 'dm_porcentaje_ganancia') ?>

    <?php // echo $form->field($model, 'dm_precio_venta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
