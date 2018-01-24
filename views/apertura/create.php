<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmVentaApertura */

$this->title = 'Apertura de caja';
/*$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Aperturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="dm-venta-apertura-create">

	<?php
	if ( Yii::$app->user->identity->tipo == 1 ){
		echo  Html::a( '<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Saltar apertura de caja', ['/site/index'], ['class' => 'btn btn-default btn-lg'] );
	}

	?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
