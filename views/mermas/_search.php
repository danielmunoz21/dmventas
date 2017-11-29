<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmMermasS */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-mermas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'merma_id') ?>

    <?= $form->field($model, 'merma_cantidad') ?>

    <?= $form->field($model, 'merma_datetime') ?>

    <?= $form->field($model, 'dm_productos_id') ?>

    <?= $form->field($model, 'dm_cajas_id') ?>

    <?php // echo $form->field($model, 'merma_descripcion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
