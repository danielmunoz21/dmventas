<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\DmProductos;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DmMermasS */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mermas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-mermas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registrar mermas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'dm_cajas_id',
                'value' => function( $data ){
                    $aCajas = app\models\DmCajas::getAll();
                    return $aCajas[ $data['dm_cajas_id'] ];
                  },  
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => app\models\DmCajas::getAll(),
                    'options' => [
                      'placeholder' => 'Seleccione Caja',  
                    ],  
                ]  

            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'dm_productos_id',
                'value' => function( $data ){
                    $aProd = \yii\helpers\ArrayHelper::map( DmProductos::find()->all(), 'dm_id_producto', 'dm_nom_producto' );
                    return $aProd[ $data['dm_productos_id'] ];
                  },  
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => \yii\helpers\ArrayHelper::map( DmProductos::find()->all(), 'dm_id_producto', 'dm_nom_producto' ),
                    'options' => [
                      'placeholder' => 'Seleccione Caja',  
                    ],  
                ]  

            ],
            'merma_cantidad',
            'merma_datetime:datetime',
            
            // 'merma_descripcion:ntext',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
