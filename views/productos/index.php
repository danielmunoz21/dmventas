<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DmProdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-productos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?php
      if ( Yii::$app->user->identity->tipo == 1 ) {

          ?>
          <p>
                  <?= Html::a( 'Registrar nuevo Producto', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
                  <?php
                  echo Html::a( '<i class="fa glyphicon glyphicon-download-alt"></i> Generar Listado Imprimible', [ '/productos/listado' ], [
                      'class'       => 'btn btn-info',
                      'target'      => '_blank',
                      'data-toggle' => 'tooltip',
                      'title'       => 'Genera PDF con listado de productos y codigos de estos'
                  ] );
                  echo ' '.  Html::a( '<i class="fa glyphicon glyphicon-download-alt"></i> Listado productos cod. generado', [ '/productos/listadocod' ], [
                      'class'       => 'btn btn-info',
                      'target'      => '_blank',
                      'data-toggle' => 'tooltip',
                      'title'       => 'Genera PDF con listado de productos y codigos de estos'
                  ] );
                  ?>
          </p>
          <?php
      }
    ?>
<?php Pjax::begin(); ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
             //['class' => 'kartik\grid\SerialColumn'],

            //'dm_id_producto',
            'dm_codigo',
            'dm_nom_producto',
            //'dm_stock_min_compras',
            'dm_stock',
            'dm_precio_compra',
            'dm_porcentaje_ganancia',
            'dm_precio_venta',
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{stock} {view} {update} {delete}',
                'buttons' => [
                    'stock' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus-sign"></span>',
                            $url, 
                            [
                                'title' => 'Agregar Stock',
                                //'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
