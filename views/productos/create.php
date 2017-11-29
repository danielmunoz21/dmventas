<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DmProductos */

$this->title = 'Registrar Producto';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-productos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'aCajas' => $aCajas,
    ]) ?>

</div>
