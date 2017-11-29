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
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('ok') ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>


<?php

echo $this->render( '_search_product', [ 'modelSearch' => $modelSearch ] );

$script2 = <<< JS


function calculartotal( cantidad, idProducto ){
	var total = cantidad * jQuery( '#costo_' + idProducto ).val();
	jQuery('#total_prod_' +  idProducto).val( total );
}



JS;
$this->registerJs($script2, View::POS_BEGIN );


echo Html::beginForm(['ventas/registrarventa'], 'post', ['enctype' => 'multipart/form-data'])
?>



<div id="ventas">
	<table id="tab_productos" class="table table-condensed">
		<thead>
			<tr>
				<td>Código</td>
				<td>Producto</td>
				<td>Valor</td>
				<td>Cantidad</td>
				<td>Total</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<tr id='addr1' class="lastrow1"></tr>
		</tbody>
	</table>
	
</div>

<?= Html::submitButton( 'Registrar venta', array( 'class' => 'btn btn-danger' ) ); ?>
<?= Html::endForm() ?> 