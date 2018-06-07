<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use kartik\dialog\DialogAsset;
DialogAsset::register($this);


/* @var $this yii\web\View */
/* @var $searchModel app\models\DmVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Venta diaria';
$this->params['breadcrumbs'][] = $this->title;


?>


<?php if(Yii::$app->session->hasFlash('ok')): ?>
        <div id="ocultar" class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('ok') ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <div id="ocultar" class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>


<?php



$script2 = <<< JS


function calculartotal( cantidad, idProducto ){
    
	var total = cantidad * jQuery( '#costo_' + idProducto ).val();
	
	var total2 = parseInt( total );

	var ultdig = total2.toString().substring( total2.toString().length -1, total2.toString().length );
	if ( ultdig <= 5 ) {
	    total2 = total2 - parseInt( ultdig );
	}
	else if( ultdig > 5 ) {
	    total2 = total2 + ( 10 - parseInt(ultdig) );
	}
	
	jQuery('#total_prod_' +  idProducto).val( total2 );
	calcularTotalVenta();
}

function calcularTotalVenta(){
    var valorGeneral = 0; 
    $('input.ventas ').each(function(){
        valorGeneral += parseInt(this.value);
    });
    
    $('#totalventa').html( '' );
    $('#totalventa').html( '$' +  valorGeneral );
    $('#totalventah').val( valorGeneral );
    
}

function calcularVuelto(){
    var vuelto = 0;
    var paga = $( '#pagacon' ).val();
    if ( paga != '' ){
    
        var total = $('#totalventah').val();
        vuelto = parseInt( paga ) - parseInt( total );
    
        $('#vuelto').html( '' );
        $('#vuelto').html( '$' +  vuelto );
    }
    else {
        $( '#vuelto' ).html( '' );
    }
    
}


/**
* Valida y procesa el formulario para su submit
*/
function validateSale() {

    $(document).ready(function(){
        $("#regvent ").find(':input.cantidad').each(function() {
         var elemento= this;
         var cantidad = parseInt(elemento.value);
         if ( cantidad > 40 ) {
           var re = confirm( 'Ha ingresado más de 40 unidades del mismo producto. ¿Está seguro de realizar esta venta?' );
           if ( re ) {
               $('#regvent').submit();
           }
         }
         else {
             $('#regvent').submit();
         }
        });
    });
}


JS;
$this->registerJs($script2, View::POS_END );

echo $this->render( '_search_product', [ 'modelSearch' => $modelSearch ] );
echo Html::beginForm(['ventas/registrarventa'], 'post', ['enctype' => 'multipart/form-data', 'id'=>'regvent']);
?>



<div id="ventas">
    <input type="hidden" name="total" value="" id="totalventah">
	<table id="tab_productos" class="table table-condensed">
		<thead>
			<tr>
				<td>Código</td>
				<td>Producto</td>
				<td>Valor unidad</td>
				<td>Cantidad</td>
				<td>Total</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<tr id='addr1' class="lastrow1"></tr>
		</tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total Venta</strong></td>
                <td id="totalventa"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;" >Paga con</td>
                <td><input type="number" value="" id="pagacon" onblur="calcularVuelto()" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;" >Vuelto</td>
                <td id="vuelto"></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
	</table>
	
</div>

<?= Html::button( 'Registrar venta', array( 'class' => 'btn btn-danger', 'id' => 'registro', 'style' => 'display:none;', 'onclick' => 'validateSale()', 'name' => 'registrar_venta' ) ); ?>
<?= Html::endForm() ?> 