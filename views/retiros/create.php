<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmVentaRetiros */

$this->title = 'Registrar Retiro';
$this->params['breadcrumbs'][] = ['label' => 'Retiros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-retiros-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aCajas' => $aCajas
    ]) ?>

</div>
