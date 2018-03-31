<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-venta-turnos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_venta_hora_inicio')->widget(TimePicker::classname(), [ 'pluginOptions' => [
    				'showSeconds' => true,
			        'showMeridian' => false,
			        'minuteStep' => 1,
			        'secondStep' => 5,
    			] ]) ?>

	<?= $form->field($model, 'dm_venta_turno_orden')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_venta_hora_termino')->widget(TimePicker::classname(), [ 'pluginOptions' => [
    				'showSeconds' => true,
			        'showMeridian' => false,
			        'minuteStep' => 1,
			        'secondStep' => 5,
    			]  ]) ?>
    <?= $form->field($model, 'dm_venta_cierre_sig_dia')->radioList( app\models\DmVentaTurnos::opciones() ); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
