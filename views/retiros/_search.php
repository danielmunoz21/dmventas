<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaRetirosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-retiros-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'retiro_id') ?>

    <?= $form->field($model, 'retiro_monto') ?>

    <?= $form->field($model, 'retiro_datetime') ?>

    <?= $form->field($model, 'dm_cajas_dm_cajas_id') ?>

    <?= $form->field($model, 'dm_usuario_dm_usuario_id') ?>

    <?php // echo $form->field($model, 'dm_venta_turnos_dm_venta_turnos_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
