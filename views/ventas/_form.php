<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-ventas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_cajas_dm_cajas_id')->textInput() ?>

    <?= $form->field($model, 'dm_usuario_dm_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_venta_cantidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_venta_turnos_dm_venta_turnos_id')->textInput() ?>

    <?= $form->field($model, 'dm_productos_dm_id_producto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
