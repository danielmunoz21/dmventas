<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
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

echo $this->render( '_search_product', [ 'modelSearch' => $modelSearch ] );

$script2 = <<< JS


function calculartotal( cantidad, idProducto ){
	var total = cantidad * jQuery( '#costo_' + idProducto ).val();
	jQuery('#total_prod_' +  idProducto).val( total );
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




JS;
$this->registerJs($script2, View::POS_HEAD );


echo Html::beginForm(['ventas/registrarventa'], 'post', ['enctype' => 'multipart/form-data'])
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

<?= Html::submitButton( 'Registrar venta', array( 'class' => 'btn btn-danger', 'id' => 'registro', 'style' => 'display:none;' ) ); ?>
<?= Html::endForm() ?> 