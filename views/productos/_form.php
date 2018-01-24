<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\DmProductos */
/* @var $form yii\widgets\ActiveForm */


$script = <<< JS
    /*function calcularPrecioVenta(){
        console.log('function');
        var iPreCompra = $("#precio_compra").val();
        var iPorGanancia = $("#por_ganancia").val();
        var cal = 0;

        if ( iPreCompra !== '' && iPorGanancia !== '' ){
            calcularredondeo();
            
        }

    }*/
    
    function calcularredondeo(){
        var form = $('#productos_form');
        var resultado = 0;
         $.ajax({
            url    : $( '#urlredondeo' ).val(),
            type   : 'POST',
            data   : form.serialize(),
            success: function (response) 
            {          
                $( "#precio_venta" ).val( response );
            },
            error  : function () 
            {
                console.log('internal server error');
            }
        });

    }
    
    function generarCodidog(){
        $.ajax({
            url    : $( '#urlgencodigo' ).val(),
            type   : 'POST',
            success: function (response) 
            {          
                if ( response == '-1' ){
                    alert( 'Código ya existe' );
                }
                else {
                    $( '#codigo' ).val( response );
                }
            },
            error  : function () 
            {
                console.log('internal server error');
            }
        });
    }
    
JS;
$this->registerJs($script, View::POS_HEAD );

?>

<div class="dm-productos-form container">

    <?php $form = ActiveForm::begin(['id' => 'productos_form']); ?>

    <?php echo Html::hiddenInput( 'urlcalculo', Yii::$app->urlManager->baseUrl . '/productos/calculoredondeo', [ 'id' => 'urlredondeo' ] ); ?>
    <?php echo Html::hiddenInput( 'urlcodigo', Yii::$app->urlManager->baseUrl . '/productos/generarcodigo', [ 'id' => 'urlgencodigo' ] ); ?>


	<?= $form->field($model, 'dm_codigo', [  'inputTemplate' => '<div class="input-group">{input}<span class="input-group-btn">'.
		                                                       '<button class="btn btn-primary" type="button" onclick="generarCodidog()"><i class="glyphicon glyphicon-barcode" aria-hidden="true"></i> Generar código de barras</button></span></div>' ])->textInput(['maxlength' => true, 'id' => 'codigo']) ?>

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
