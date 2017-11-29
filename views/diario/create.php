<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmVentaDiario */

$this->title = 'Create Dm Venta Diario';
$this->params['breadcrumbs'][] = ['label' => 'Dm Venta Diarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-diario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
