<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmUsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dm_usuario_id') ?>

    <?= $form->field($model, 'dm_usuario_nombre') ?>

    <?= $form->field($model, 'dm_usuario_clave') ?>

    <?= $form->field($model, 'dm_tipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
