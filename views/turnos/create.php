<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmVentaTurnos */

$this->title = 'Registrar Turno';
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-turnos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
