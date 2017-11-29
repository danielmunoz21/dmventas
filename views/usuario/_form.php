<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DmUsuario;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\DmUsuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_usuario_id')->hiddenInput()->label('') ?>

    <?= $form->field($model, 'dm_usuario_nombre')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'dm_nom_login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_usuario_clave')->widget(PasswordInput::classname(), [
		    'pluginOptions' => [
		        'showMeter' => true,
		        'toggleMask' => true,

		    ]
		])->hint('Clave acepta A-Za-z0-9')->label('') ?>

    <?= $form->field($model, 'dm_tipo')->dropDownList( DmUsuario::$aTipos, [ 'prompt' => '-Seleccione--' ] ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
