<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmCajas */

$this->title = 'Rejistrar caja';
$this->params['breadcrumbs'][] = ['label' => 'Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-cajas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
