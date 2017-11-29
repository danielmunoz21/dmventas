<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-diario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dm_venta_diario_id') ?>

    <?= $form->field($model, 'dm_venta_total') ?>

    <?= $form->field($model, 'dm_venta_datetime') ?>

    <?= $form->field($model, 'dm_usuario_dm_usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
