<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmProductos */

$this->title = $model->dm_nom_producto;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$aCajas = app\models\DmCajas::getAll();

?>
<div class="dm-productos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->dm_id_producto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->dm_id_producto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este producto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'dm_id_producto',
            'dm_codigo',
            'dm_nom_producto',
            'dm_stock_min_compras',
            'dm_stock',
            //'dm_precio_compra',
            [
                'attribute' => 'dm_precio_compra',
                //'value' => Yii::$app->formatter->asCurrency( $model->dm_precio_compra)        
            ],
            'dm_porcentaje_ganancia',
            'dm_precio_venta',
            [
                'attribute' => 'dm_cajas_id',
                'value' => $aCajas[ $model->dm_cajas_id ],
            ]
        ],
    ]) ?>



</div>
