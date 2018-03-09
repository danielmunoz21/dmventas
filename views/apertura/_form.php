<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmVentaApertura */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="dm-venta-apertura-form">

    <?php $form = ActiveForm::begin(); ?>




    <?= $form->field($model, 'dm_apert_monto')->textInput(['maxlength' => true])->hint( 'Monto con el cual se inicia su periodo' ) ?>
	<?php echo yii\helpers\Html::activeHiddenInput( $model, 'dm_apert_fecha' ); ?>
	<?php echo yii\helpers\Html::activeHiddenInput( $model, 'dm_usuario_id' ); ?>
	<?php echo yii\helpers\Html::activeHiddenInput( $model, 'dm_turnos_id' ); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
