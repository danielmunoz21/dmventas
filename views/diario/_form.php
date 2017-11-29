<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaDiario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-diario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_venta_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_venta_datetime')->textInput() ?>

    <?= $form->field($model, 'dm_usuario_dm_usuario_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
