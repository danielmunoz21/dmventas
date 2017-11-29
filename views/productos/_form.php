<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\DmProductos */
/* @var $form yii\widgets\ActiveForm */


$script = <<< JS
    function calcularPrecioVenta(){
        console.log('function');
        var iPreCompra = $("#precio_compra").val();
        var iPorGanancia = $("#por_ganancia").val();
        var cal = 0;

        if ( iPreCompra !== '' && iPorGanancia !== '' ){
            cal = parseInt( iPreCompra ) * ( (parseInt( iPorGanancia ) / 100 )+ 1.19 ) ;
            $( "#precio_venta" ).val( Math.round( cal ) );    
        }

    }
JS;
$this->registerJs($script, View::POS_HEAD );

?>

<div class="dm-productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dm_codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_nom_producto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dm_stock_min_compras')->textInput() ?>

    <?= $form->field($model, 'dm_stock')->textInput() ?>

    <?= $form->field($model, 'dm_precio_compra')->textInput([ 'id' => 'precio_compra' ]) ?>

    <?= $form->field($model, 'dm_porcentaje_ganancia')->textInput(['maxlength' => true, 'id' => 'por_ganancia', 'onblur' => 'js:calcularPrecioVenta()']) ?>

    <?= $form->field($model, 'dm_precio_venta')->textInput([ 'id' => 'precio_venta' ]) ?>

    <?= $form->field($model, 'dm_cajas_id')->dropDownList( $aCajas, [ 'prompt' => 'Seleccione Caja' ] ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
