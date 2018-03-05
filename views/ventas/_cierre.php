<?php 

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DmProductos;

$this->title = 'Cierre Turno';
$this->params['breadcrumbs'][] = $this->title;


?>

<h1>Cierre de Turno  <?=$modelTurno->dm_nombre?></h1>

<?php echo $this->render( '__datacierre', [ 'aCierres' => $aCierres,
                                            'aCajas' => $aCajas,
                                            'modelTurno' => $modelTurno,
                                            'iMontoApertura' => $iMontoApertura, ] ); ?>

<?php
echo Html::a('<i class="fa glyphicon glyphicon-download-alt"></i> Generar Retiro turno', ['/ventas/pdfcierre'], [
	'class'=>'btn btn-info',
	'target'=>'_blank',
	'data-toggle'=>'tooltip',
	'title'=>'Genera PDF montos y ventas del turno.'
]);
?>
