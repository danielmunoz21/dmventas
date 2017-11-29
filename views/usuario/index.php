<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\DmUsuario;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DmUsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registrar usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'columns' =>[
            ['class' => 'kartik\grid\SerialColumn'],

                //'dm_usuario_id',
                'dm_usuario_nombre',
                'dm_nom_login',
                //'dm_usuario_clave:ntext',
                [
                    'attribute' => 'dm_tipo',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'data' => DmUsuario::$aTipos,
                        'options' => ['placeholder' => 'Selecione tipo de usuario ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                    'value' => function( $data ){
                        return  DmUsuario::$aTipos[ $data->dm_tipo ];
                    }
                ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'responsive'=>true,
        'hover'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
    ]); ?>
<?php Pjax::end(); ?></div>
