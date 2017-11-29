<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmVentas */

$this->title = 'Create Dm Ventas';
$this->params['breadcrumbs'][] = ['label' => 'Dm Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-ventas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
