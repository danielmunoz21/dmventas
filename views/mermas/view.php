<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use app\models\DmProductos;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DmMermas */

$this->title = $model->merma_id;
$this->params['breadcrumbs'][] = ['label' => 'Mermas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//
//


$aCajas = app\models\DmCajas::getAll();
$aProductos = \yii\helpers\ArrayHelper::map( DmProductos::find()->all(), 'dm_id_producto', 'dm_nom_producto' );

?>
<div class="dm-mermas-view">

    <p>
        
        <?= Html::a('Actualizar', ['update', 'id' => $model->merma_id], ['class' => 'btn btn-primary']) ?>

        
        <?= Html::a('Eliminar', ['delete', 'id' => $model->merma_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta merma ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'merma_id',
            [
                'attribute' => 'dm_cajas_id',
                'value' => $aCajas[ $model->dm_cajas_id ]
            ],
            [
                'attribute' => 'dm_productos_id',
                'value' => $aProductos[ $model->dm_productos_id ]
            ],
            'merma_cantidad',
            'merma_datetime:datetime',
            'merma_descripcion:ntext',
        ],
    ]) ?>

</div>
