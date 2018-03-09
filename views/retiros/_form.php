<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaRetiros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-retiros-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo Html::activeHiddenInput( $model, 'retiro_datetime' );  ?>
    <?php echo Html::activeHiddenInput( $model, 'dm_usuario_dm_usuario_id' );  ?>
    <?php echo Html::activeHiddenInput( $model, 'dm_venta_turnos_dm_venta_turnos_id' );  ?>

    <?= $form->field($model, 'retiro_monto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_cajas_dm_cajas_id')->dropDownList( $aCajas, [ 'prompt' => 'Seleccione Caja' ] ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
