<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use keygenqt\autocompleteAjax\AutocompleteAjax;


$script = <<< JS
var i=1;  
var total_venta = 0;
function procesar(e){
        if ( $('#searchprod').val() !== '' ){
            
        
            $(document).ready(function(){ 
                 
                  var form = $('#searchproducto');
                  $.ajax({
                        url    : form.attr('action'),
                        type   : 'POST',
                        data   : form.serialize(),
                        success: function (response) 
                        {          
                            if ( response == -1 ){
                                alert( 'Producto no encontrado' );
                                $('#searchprod').val( '' );
                                $('#registro').attr('style', 'none');
                                $('#searchprod').focus();
                            }
                            else {
                                
                                $('#addr' + i).html(response);
                                $("#tab_productos  tbody tr.lastrow"+i).after('<tr id="addr'+(i+1)+'" class="lastrow'+(i+1)+'"></tr>');
                                i++;   
                                $('#searchprod').val( '' );
                                $('#registro').removeAttr( 'style' );
                                calcularTotalVenta();
                                $('#searchprod').focus();
                            }
                        },
                        error  : function () 
                        {
                            console.log('internal server error');
                        }
                    });
                return false;
            });
        }
}



jQuery(document).on('click', '.borrar', function (event) {
    event.preventDefault();
    jQuery(this).closest('tr').remove();
    calcularTotalVenta();
});

$(document).ready(function(){
    $('#searchprod').focus();
});

JS;
$this->registerJs($script, View::POS_END);


?>
<div class="dm-ventas-search">
    
        <?php $form = ActiveForm::begin([
            'id' => 'searchproducto',
            'action' => ['ventas/agregarproducto'],
            'method' => 'post',
        ]); ?>

        <?php /*$form->field($modelSearch, 'dm_nom_producto')->widget(AutocompleteAjax::classname(), [
            'multiple' => false,
            'url' => ['ventas/searchproducto'],
            'options' => ['placeholder' => 'Ingrese nombre del producto o código.', 'onkeypress' => 'procesar(event)']
        ]);*/ ?>

        <?=  $form->field( $modelSearch, 'dm_codigo' )->textInput( [ 'placeholder' => 'Ingrese código de producto', 'onblur' => 'procesar(event)', 'id' => 'searchprod' ] ); ?>
        

        <?php ActiveForm::end(); ?>

</div>