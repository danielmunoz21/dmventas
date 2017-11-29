<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmMermas */

$this->title = 'Registrar Merma';
$this->params['breadcrumbs'][] = ['label' => 'Mermas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-mermas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aProductos' => $aProductos,
        'aCajas' => $aCajas,
    ]) ?>

</div>
