<?php
use yii\helpers\Html;
use kartik\detail\DetailView;

?>
<?= DetailView::widget([
	'model' => $modelDiario,
	'attributes' => [

		'dm_venta_total',
		[
			'attribute' => 'dm_usuario_dm_usuario_id',
			'value' => $aUsuarios[ $modelDiario->dm_usuario_dm_usuario_id ],
		],
		[
			'attribute' => 'dm_venta_turno_id',
			'value' => $aTurnos[ $modelDiario->dm_venta_turno_id ],
		],

	],
]); ?>
