<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->title = 'Agregar Stock';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="dm-ventas-stock">
	<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_codigo')->hiddenInput()->label(false);?>

    <?= $form->field($model, 'dm_nom_producto')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'dm_stock_min_compras')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'dm_stock')->textInput()->hint('Stock actual del producto no se debe sumar si no agregar la cantidad que se adquiere el sistema internamente realiza el calculo.'); ?>

    <?= $form->field($model, 'dm_precio_compra')->hiddenInput()->label(false);?>

    <?= $form->field($model, 'dm_porcentaje_ganancia')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'dm_precio_venta')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'dm_cajas_id')->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Actualizar Stock', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>