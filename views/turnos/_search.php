<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-turnos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dm_venta_turnos_id') ?>

    <?= $form->field($model, 'dm_nombre') ?>

    <?= $form->field($model, 'dm_venta_hora_inicio') ?>

    <?= $form->field($model, 'dm_venta_hora_termino') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
